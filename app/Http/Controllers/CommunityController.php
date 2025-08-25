<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityRequest;
use App\Mail\CommunityCreated;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('community.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ['cars', 'parts', 'general', 'help'];
        return view('community.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommunityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommunityRequest $request)
    {
        $community = $request->user()->communities()->create($request->validated());

        Mail::to($request->user())->send(new CommunityCreated($community));

        return to_route('communities.index')->with('success', trans('general.question_posted'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community)
    {
        $community->load(['user:id,first_name,last_name,email,type']);
        return view('community.show', compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function edit(Community $community)
    {
        abort_if(is_reported('community', $community->id, 'other'), 403);
        $categories = ['cars', 'parts', 'general', 'help'];
        return view('community.edit', compact('community', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CommunityRequest  $request
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(CommunityRequest $request, Community $community)
    {
        abort_if(is_reported('community', $community->id, 'other'), 403);
        $community->update($request->validated());
        return to_route('communities.index')->with('success', trans('general.question_edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        abort_if(is_reported('community', $community->id, 'other'), 403);
        $community->reports()->delete();
        foreach ($community->comments() as $comment) {
            $comment->reports()->delete();
            $comment->sub_comments()->delete();
        }
        $community->delete();

        return to_route('communities.index')->with('success', trans('general.question_deleted'));
    }
}
