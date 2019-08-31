<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Response;

class ThreadsCommentsController extends Controller
{

    /**
     * @param Thread $thread
     * @return mixed
     */
    public function index(Thread $thread)
    {
        return $thread->comments;
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($channelId, Thread $thread)
    {
        if ($thread) {
            return \response()->json($thread, Response::HTTP_OK);
        }

        return \response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Thread $thread)
    {

        if ($thread->user_id !== auth()->id()) {
            if (\request()->wantsJson()) {
                return \response()->json(['status' => 'Permission denied'], Response::HTTP_FORBIDDEN);
            }
        }

        \request()->validate([
            'body' => 'required|spamfree',
        ]);

        $comment = $thread->addComment([
            'body' => \request()->body,
            'image_url' => \request()->image_url,
            'thread_url' => request()->thread_url,
        ]);

        return response()->json(
            [
                'message' => 'کامنت با موفقیت ثبت شد.',
                'comment' => $comment,
            ]
            , Response::HTTP_CREATED);
    }
}
