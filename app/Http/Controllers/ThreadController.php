<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
  /**
   * ThreadController constructor.
   */
  public function __construct() {
  	$this->middleware('auth')->except('index','show');
  }


  /**
   * Display a listing of the resource.
   *
   * @param \App\Channel $channel
   * @param \app\Filters\ThreadFilters $filters
   * @return \Illuminate\Http\Response
   */
    public function index(Channel  $channel, ThreadFilters $filters)
    {

	  $threads = $this->getThreds($channel, $filters);

        return view('thread.index',compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $this->validate($request,[
        'title'=>'required',
		'body'=>'required',
		'channel_id'=>'required|exists:channels,id'
	  ]);
        $thread = Thread::create([
          'title'=>$request->title,
		  'channel_id'=>$request->channel_id,
		  'body'=>$request->body,
		  'user_id'=>auth()->id()
		]);
        return redirect($thread->path());
    }

  /**
   * Display the specified resource.
   *
   * @param $channelId
   * @param  \App\Thread $thread
   * @return \Illuminate\Http\Response
   */
    public function show($channelId , Thread $thread)
    {
      	$thread->load('replies.owner','creator','channel');
        return view('thread.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

  /**
   * @param \App\Channel $channel
   * @param \App\Filters\ThreadFilters $filters
   * @return \App\Thread|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection|static[]
   */
  public function getThreds(Channel $channel, ThreadFilters $filters) {
	$threads = Thread::latest()->filter($filters);

	if ($channel->exists) {
	  $threads->where('channel_id', $channel->id);
	}

	$threads = $threads->get();
	return $threads;
  }
}
