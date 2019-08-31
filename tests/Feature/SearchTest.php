<?php
//
//namespace Tests\Feature;
//
//use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//
//class SearchTest extends TestCase
//{
//    use RefreshDatabase;
//
//    function a_user_can_search_thread()
//    {
//        $search = 'foobar';
//        create('App\Thread', [], 2);
//        create('App\Thread', ['body' => "a thread with the {$search} term"], 2);
//        $results = $this->getJson("/threads/search?q={$search}")->json();
//        $this->assertCount(2, $results);
//    }
//
//}
