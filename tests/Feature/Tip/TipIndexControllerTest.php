<?php

namespace Tests\Feature\Tip;

use App\Http\Middleware\AuthenticateJwt;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Tip;
use Tests\Feature\Support\CreatesTipMsSchema;
use Tests\TestCase;

class TipIndexControllerTest extends TestCase
{
    use CreatesTipMsSchema;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareTipMsSchema();
        $this->withoutMiddleware([AuthenticateJwt::class, RoleMiddleware::class]);
    }

    public function test_user_can_view_only_active_tips_in_app_and_admin_can_view_all(): void
    {
        $activeTip = new Tip();
        $activeTip->title = 'Compacta las cajas de cartón';
        $activeTip->description = 'Desarma las cajas para optimizar el espacio.';
        $activeTip->is_active = true;
        $activeTip->save();

        $inactiveTip = new Tip();
        $inactiveTip->title = 'Tip inactivo';
        $inactiveTip->description = 'No debe mostrarse en la app móvil.';
        $inactiveTip->is_active = false;
        $inactiveTip->save();

        $appResponse = $this->getJson('/api/tips_app');

        $appResponse->assertOk();
        $appResponse->assertJsonCount(1, 'data');
        $appResponse->assertJsonPath('data.0.id', $activeTip->id);
        $appResponse->assertJsonPath('data.0.title', 'Compacta las cajas de cartón');

        $webResponse = $this->getJson('/api/tips_web');

        $webResponse->assertOk();
        $webResponse->assertJsonCount(2, 'data');
    }
}

