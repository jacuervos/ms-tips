<?php

namespace Tests\Feature\Tip;

use App\Http\Middleware\AuthenticateJwt;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Tip;
use Tests\Feature\Support\CreatesTipMsSchema;
use Tests\TestCase;

class TipUpdateAndChangeStateControllerTest extends TestCase
{
    use CreatesTipMsSchema;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareTipMsSchema();
        $this->withoutMiddleware([AuthenticateJwt::class, RoleMiddleware::class]);
    }

    public function test_admin_can_update_tip_title_and_description(): void
    {
        $tip = new Tip();
        $tip->title = 'Tip inicial';
        $tip->description = 'Descripción inicial';
        $tip->is_active = true;
        $tip->save();

        $response = $this->patchJson("/api/{$tip->id}/tips_web", [
            'title' => 'Tip actualizado',
            'description' => 'Descripción actualizada con nuevos consejos de reciclaje.',
        ]);

        $response->assertOk();
        $response->assertJsonPath('code', 200);
        $response->assertJsonPath('message', 'Se ha actualizado el tip correctamente');
        $response->assertJsonPath('tip.title', 'Tip actualizado');

        $this->assertDatabaseHas('tips', [
            'id' => $tip->id,
            'title' => 'Tip actualizado',
            'description' => 'Descripción actualizada con nuevos consejos de reciclaje.',
        ]);
    }

    public function test_admin_can_toggle_tip_active_state(): void
    {
        $tip = new Tip();
        $tip->title = 'Reutiliza bolsas';
        $tip->description = 'Usa bolsas de tela reutilizables.';
        $tip->is_active = true;
        $tip->save();

        $disableResponse = $this->patchJson("/api/{$tip->id}/change_state_tips");

        $disableResponse->assertOk();
        $disableResponse->assertJsonPath('message', 'Cambio de estado correctamente');
        $disableResponse->assertJsonPath('tip.is_active', false);

        $this->assertDatabaseHas('tips', [
            'id' => $tip->id,
            'is_active' => 0,
        ]);

        $enableResponse = $this->patchJson("/api/{$tip->id}/change_state_tips");

        $enableResponse->assertOk();
        $enableResponse->assertJsonPath('tip.is_active', true);
    }
}

