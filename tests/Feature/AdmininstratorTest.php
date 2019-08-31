<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdmininstratorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_administrator_can_access_the_admin_panel()
    {
        $this->signInAdmin();
        $this->get('/admin')->assertStatus(200);
    }

    /**
     * @test
     */
    public function a_non_administrator_cannot_access_the_admin_panel()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $admin = create('App\User');
        $this->actingAs($admin)->get(route('admin.dashboard.index'));
    }

}
