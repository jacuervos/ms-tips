<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use App\Http\Resources\TipResource;

class TipChangeStateController extends Controller
{
    public function changeStateTip(Tip $tip)
    {

        $tip->is_active = !$tip->is_active;
        $tip->save();
        $tipResource = TipResource::make($tip);
        $data = [
            'message' => 'Cambio de estado correctamente',
            'tip' => $tipResource,
            'code' => 200,
        ];
        return response()->json($data);
    }
}
