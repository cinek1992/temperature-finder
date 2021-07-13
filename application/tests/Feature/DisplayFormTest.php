<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisplayFormTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_display_form()
    {
        $response = $this->get('/');

        $response->assertDontSeeText('Temperature for country ');
        $response->assertSeeText('Temperature finder');
        $response->assertSeeText('Show temperature');
        $response->assertSeeText('Powered by:');

        $response->assertStatus(200);
    }
}
