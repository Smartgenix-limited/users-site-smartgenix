<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Community as ModelsCommunity;
use App\Models\CommunityComment;
use Livewire\Component;
use Livewire\WithPagination;

class Community extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $type = 'all', $categories = ['all'], $category = 'all', $search = '';

    public function mount()
    {
        $this->categories = array_merge($this->categories, Category::select('name')->get()->map(fn ($category) => $category->name)->toArray());
    }

    public function render()
    {
        if ($this->type === 'all') {
            $communities = ModelsCommunity::whereNot('user_id', auth()->id())->when($this->category !== 'all', fn ($q) => $q->where('category', $this->category))->when($this->search !== '', fn ($q) => $q->whereLike('title', $this->search)->OrWhereLike('message', $this->search))->latest()->paginate(10);
        } elseif ($this->type === 'my') {
            $communities = request()->user()->communities()->when($this->search !== '', fn ($q) => $q->whereLike('title', $this->search)->OrWhereLike('message', $this->search))->latest()->paginate(10);
        } else {
            $communities = request()->user()->comments()->when($this->search !== '', fn ($q) => $q->whereLike('comment', $this->search))->latest()->paginate(10);
        }
        return view('livewire.community', [
            'communities' => $communities
        ]);
    }

    public function changeType($type)
    {
        $this->type = $type;
    }

    public function changeCategory($category)
    {
        $this->category = $category;
    }

    public function deleteComment(CommunityComment $comment)
    {
        $comment->delete();
    }

    // public function updatedCategory()
    // {
    //     dd($this->category);
    // }
}
