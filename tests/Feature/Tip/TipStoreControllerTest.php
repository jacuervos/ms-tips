<?php

namespace Tests\Feature\Tip;

use App\Http\Middleware\AuthenticateJwt;
use App\Http\Middleware\RoleMiddleware;
use Tests\Feature\Support\CreatesTipMsSchema;
use Tests\TestCase;

class TipStoreControllerTest extends TestCase
{
    use CreatesTipMsSchema;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareTipMsSchema();
        $this->withoutMiddleware([AuthenticateJwt::class, RoleMiddleware::class]);
    }

    public function test_admin_can_create_tip_with_active_state_by_default(): void
    {
        $response = $this->postJson('/api/tips_web', [
            'title' => 'Separa los envases plásticos',
            'description' => 'Enjuaga y seca las botellas PET antes de entregarlas al recolector.',
        ]);

        $response->assertOk();
        $response->assertJsonPath('code', 200);
        $response->assertJsonPath('message', 'Se ha creado el tip correctamente');
        $response->assertJsonPath('tip.title', 'Separa los envases plásticos');
        $response->assertJsonPath('tip.is_active', true);

        $this->assertDatabaseHas('tips', [
            'title' => 'Separa los envases plásticos',
            'is_active' => 1,
        ]);
    }

    public function test_create_tip_validates_required_title_and_description(): void
    {
        $response = $this->postJson('/api/tips_web', []);

        $response->assertStatus(422);
    }
}

