<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');
        $analysis = create('App\Analysis');
        $this->post(route('threads.store', $analysis->id), $thread->toArray());
    }
    
    /**
     * @test
     */
    function new_users_must_first_confirm_their_email_address_befor_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);
        $thread = make('App\Thread');
        $analysis = create('App\Analysis');
        $this->post(route('threads.store', $analysis->id), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash');
    }

    /**
     * @test
     */
    function guests_cannot_see_the_create_thread_page()
    {

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $analysis = create('App\Analysis');
        $response = $this->get(route('threads.create', $analysis->id));
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    function a_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some title', 'body' => 'Some Body.']);
        $response = $this->get($response->headers->get('Location'));
        $response->assertSee('Some title');
        $response->assertSee('Some Body.');
    }

    /**
     * @test
     */
    function a_thread_requires_a_title()
    {
        $response = $this->publishThread(['title' => null]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function a_thread_requires_a_body()
    {
        $response = $this->publishThread(['body' => null]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();
        $response = $this->publishThread(['channel_id' => null]);
        $response->assertStatus(422);
        $response = $this->publishThread(['channel_id' => 999]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create('App\Thread', ['title' => 'Foo Title', 'slug' => 'foo-title']);
        $this->assertEquals($thread->fresh()->slug, 'foo-title');
        $analysis = create('App\Analysis');
        $this->post(route('threads.store', $analysis->id), $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('foo-title-2')->exists());
    }

//    /**
//     * @test
//     */
//    function a_thread_requires_recaptcha_verification()
//    {
//        $response = $this->publishThread(['g-recaptcha-response' => 'test']);
//        $response->assertStatus(302);
//
//    }

    /**
     * @test
     */
    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();
        $thread = create('App\Thread', ['title' => 'Some title 24', 'slug' => 'some-title-24']);
        $analysis = create('App\Analysis');
        $this->post(route('threads.store', $analysis->id), $thread->toArray() + ['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('some-title-25')->exists());
    }

    /**
     * @test
     */
    function unauthorized_users_may_not_delete_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');
        $this->delete($thread->path());
        $this->signIn();
        $response = $this->delete($thread->path());
        $response->assertStatus(403);

    }

    /**
     * @test
     */
    function authorized_users_can_delete_thread()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
        $analysis = create('App\Analysis');
        return $this->post(route('threads.store', $analysis->id), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }


}
