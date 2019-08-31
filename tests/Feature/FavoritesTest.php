<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guests_can_not_favorite_anything()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('replies/1/favorites');
    }

    /**
     * @test
     */
    function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    function an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $reply->favorite();
        $this->assertCount(1, $reply->favorites);
        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->fresh()->favorites);
    }

    /**
     * @test
     */
    function a_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function guests_can_not_favorite_any_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('threads/1/favorites');
    }

    /**
     * @test
     */
    function an_authenticated_user_can_favorite_any_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post('threads/' . $thread->slug . '/favorites');
        $this->assertCount(1, $thread->favorites);
    }

    /**
     * @test
     */
    function an_authenticated_user_can_unfavorite_any_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
//        $thread->favorite();
//        $this->assertCount(1, $thread->favorites);
        $this->delete('/threads/' . $thread->id . '/favorites');
        $this->assertCount(0, $thread->fresh()->favorites);
    }

    /**
     * @test
     */
    function a_authenticated_user_may_only_favorite_a_thread_once()
    {
        $this->signIn();
        $thread = create('App\Thread');
        try {
            $this->post('threads/' . $thread->id . '/favorites');
            $this->post('threads/' . $thread->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $thread->favorites);
    }

}
