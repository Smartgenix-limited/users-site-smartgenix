<?php

namespace App\Http\Livewire;

use App\Mail\CommentPosted;
use App\Models\Community;
use App\Models\CommunityComment;
use App\Notifications\ReplyNotification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CommunityComments extends Component
{
    public $community, $comment_show = false, $sub_comment_show = false, $sub_comment_id = null, $is_edit = false, $edit_id;
    public $comment = '';
    public $is_report = false, $report_type = '', $report_id, $reason = '';

    public function render()
    {
        return view('livewire.community-comments', [
            'comments' => CommunityComment::with(['user:id,first_name,last_name', 'sub_comments'])->where('community_id', $this->community->id)->whereNull('comment_id')->latest()->get(),
            'comments_count' => CommunityComment::where('community_id', $this->community->id)->count()
        ]);
    }

    public function toggleShowComment()
    {
        $this->comment_show = !$this->comment_show;
    }

    public function toggleSubComment($id)
    {
        $this->sub_comment_id = $id;
        $this->sub_comment_show = true;
    }

    public function addComment()
    {
        $this->community->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $this->comment
        ]);

        if ($this->community->id != auth()->id()) {
            Mail::to($this->community->user)->send(new CommentPosted($this->community, $this->comment));
        }
        $this->comment_show = false;
        $this->comment = '';
    }

    public function addSubComment()
    {
        $this->community->comments()->create([
            'comment_id' => $this->sub_comment_id,
            'user_id' => auth()->id(),
            'comment' => $this->comment
        ]);
        if ($this->community->id != auth()->id()) {
            Mail::to($this->community->user)->send(new CommentPosted($this->community, $this->comment));
        }
        $this->sub_comment_id = null;
        $this->sub_comment_show = false;
        $this->comment = '';
    }

    public function editComment($id)
    {
        $this->edit_id = $id;
        $this->is_edit = true;
        $this->comment = CommunityComment::find($id)?->comment;
    }

    public function updateComment($id)
    {
        CommunityComment::find($id)->update(['comment' => $this->comment]);
        $this->is_edit = false;
        $this->edit_id = null;
        $this->comment = '';
    }

    public function deleteComment($id)
    {
        $comment = CommunityComment::find($id);
        $comment?->sub_comments()?->delete();
        $comment?->delete();
    }

    public function toggleReportModel($type = null, $id = null)
    {
        $this->is_report = !$this->is_report;

        if ($this->is_report) {
            $this->report_type = $type;
            $this->report_id = $id;
        } else {
            $this->report_type = '';
            $this->report_id = null;
            $this->reason = '';
        }
    }

    public function reportComment()
    {
        if ($this->report_type === 'community') {
            $report_model = Community::find($this->report_id);
        } else {
            $report_model = CommunityComment::find($this->report_id);
        }

        $report_model->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $this->reason,
        ]);

        $this->is_report = false;
        $this->report_type = '';
        $this->report_id = null;
        $this->reason = '';
    }
}
