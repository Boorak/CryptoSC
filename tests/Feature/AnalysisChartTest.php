<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalysisChartTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    function guests_may_not_create_analysis()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Analysis');
        $this->post(route('analysis.store'), $thread->toArray());
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_add_new_analysis_chart_data()
    {
        $this->signIn();
        $analysis = make('App\Analysis');
        $response = $this->post(route('analysis.store'), $analysis->toArray());
        $response->assertStatus(201);
    }

    /**
     * @test
     */
    function user_with_valid_analysis_can_see_create_thread_form()
    {
        $this->signIn();
        $analysis = create('App\Analysis', ['user_id' => auth()->id()]);
        $this->get("/threads/create?analysis_id=$analysis->id")
            ->assertSee($analysis->image_full_path);
    }

    /**
     * @test
     */
    function user_with_published_analysis_can_not_see_create_thread_form()
    {
        $this->signIn();
        $analysis = create('App\Analysis', ['user_id' => auth()->id(), 'published' => true]);
        $this->get("/threads/create?analysis_id=$analysis->id")
            ->assertDontSee($analysis->image_full_path)
            ->assertRedirect('/analysis/chart');
    }
}
