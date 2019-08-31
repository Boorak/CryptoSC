<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function non_administrator_may_not_lock_threads()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread))->assertStatus(403);
        $this->assertFalse(!!$thread->fresh()->locked);
    }

    /**
     * @test
     */
    function administrators_can_lock_threads()
    {
        $this->signInAdmin();
        $thread = create('App\Thread', ['user_id' => auth()->id(),'locked' => true]);
        $this->post(route('locked-threads.store', $thread));
        $this->assertTrue($thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }

    /**
     * @test
     */
    function administrators_can_unlock_threads()
    {
        $this->signInAdmin();
        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => false]);
        $this->delete(route('locked-threads.destroy', $thread));
        $this->assertFalse($thread->fresh()->locked, 'Failed asserting that the thread was unlocked.');
    }

    /**
     * @test
     */
    function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread',['locked' => true]);
        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);

    }
}
