<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function only_member_can_add_avatars()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $response = $this->json('POST', 'api/users/1/avatar');
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    function a_valid_avatar_must_be_provided()
    {
        $this->signIn();
        $response = $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => 'not-an-image',
        ]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    function a_user_may_can_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals(asset('/storage/avatars/' . $file->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
