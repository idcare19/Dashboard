<?php

namespace Tests\Feature;

use App\Models\PortfolioSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_api_returns_dynamic_data(): void
    {
        PortfolioSetting::create([
            'site_title' => 'Portfolio • API',
            'person_name' => 'API User',
            'hero_title' => 'Hello API',
            'hero_subtitle' => 'From DB',
            'socials' => [
                ['platform' => 'GitHub', 'url' => 'https://github.com/idcare19', 'handle' => '@idcare19'],
            ],
        ]);

        $response = $this->getJson('/api/portfolio');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.person_name', 'API User')
            ->assertJsonPath('data.site_title', 'Portfolio • API');
    }

    public function test_contact_api_stores_message(): void
    {
        $response = $this->postJson('/api/contact', [
            'name' => 'Vercel User',
            'email' => 'vercel@example.com',
            'message' => 'Hello from Vercel frontend',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Vercel User',
            'email' => 'vercel@example.com',
        ]);
    }

    public function test_contact_api_validates_payload(): void
    {
        $response = $this->postJson('/api/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}
