<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');
        $this->post($thread->path() . '/replies', []);
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_participate_in_forum_threats()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());
//        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }


    /**
     * @test
     */
    function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $response = $this->post($thread->path() . '/replies', $reply->toArray());
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}");
        $this->assertEquals(0, $reply->thread->replies_count);

    }

    /**
     * @test
     */
    function authorized_user_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $response = $this->delete("/replies/{$reply->id}");
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $response = $this->patch("/replies/{$reply->id}", ['body' => 'You been changed, fool']);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    function unauthorized_users_cannot_update_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create('App\Reply');
        $this->patch("/replies/{$reply->id}", ['body' => 'You been changed, fool']);

    }

    /**
     * @test
     */
    function replies_that_contain_spam_may_not_be_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);
        $response = $this->post($thread->path() . '/replies', $reply->toArray());
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function users_may_only_reply_a_maximum_of_one_per_minute()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'My standard reply'
        ]);

        $response = $this->post($thread->path() . '/replies', $reply->toArray());
        $response->assertStatus(200);

        $response = $this->post($thread->path() . '/replies', $reply->toArray());
        $response->assertStatus(429);
    }

}
