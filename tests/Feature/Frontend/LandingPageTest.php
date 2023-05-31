<?php

namespace Tests\Feature\Frontend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_anyone_can_access_landing_page()
    {
        $response = $this->get(route('homepage'));
        $response->assertViewIs('frontend.home.index');
        $response->assertStatus(200);
    }
}
