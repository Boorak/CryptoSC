<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_validates_spam()
    {

        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');

    }

    /**
     * @test
     */
    function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        $this->expectException('Exception');
        $spam->detect('Hello world aaaaaaaa');
    }

}
