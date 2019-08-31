<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'John@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
        ]);


        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    /**
     * @test
     */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();
        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'John@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ["token" => $user->confirmation_token]))
            ->assertRedirect(route('threads'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });

    }

    /**
     * @test
     */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ["token" => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'Unknown token.');
    }

}
