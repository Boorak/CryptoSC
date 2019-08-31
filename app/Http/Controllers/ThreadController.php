<?php

namespace App\Http\Controllers;

use App\Analysis;
use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return ThreadController|\Illuminate\Contracts\View\Factory|\Illuminate\Database\Query\Builder|\Illuminate\View\View
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (\request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }

    /**
     * @param $channel
     * @param Thread $thread
     * @param Trending $trending
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
//        return Thread::withCount('replies')->first();
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->visits()->record();

        return view('threads.show', compact('thread'));
    }

    public function create()
    {

        $analysisId = \request()->analysis_id;

        if (!$analysis = Analysis::isValidAnalysis($analysisId)) {
            return redirect('/analysis/chart');
        }

        return view('threads.create', compact('analysis'));
    }

    /**
     * @param $analysisId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($analysisId)
    {
        //Handle invalid analysisId

        \request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ]);

        $thread = Thread::create(
            [
                'user_id' => auth()->id(),
                'channel_id' => \request('channel_id'),
                'title' => \request('title'),
                'body' => \request('body'),
                'slug' => \request('title'),
                'analysis_id' => $analysisId,
            ]
        );

        $thread->analysis->update(['published' => true]);

        return redirect($thread->path())
            ->with('flash', 'تحلیل با موفقیت ثبت شد.');
    }

    public function update($channel, Thread $thread)
    {

        $this->authorize('update', $thread);

        $thread->update(\request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
        ]));

        return $thread;
    }

    /**
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy($channel, Thread $thread)
    {

        $this->authorize('update', $thread);

        $thread->delete();

        if (\request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest();
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        $threads = $threads->filter($filters);
        return $threads->paginate(10);
    }

}
