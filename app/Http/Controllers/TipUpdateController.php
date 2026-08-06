<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipUpdateRequest;
use App\Http\Resources\TipResource;
use App\Models\Tip;

class TipUpdateController extends Controller
{
    public function update(TipUpdateRequest $tipUpdateRequest, Tip $tip)
    {
        $tip->title = $tipUpdateRequest->title;
        $tip->description = $tipUpdateRequest->description;

        $tip->save();
        $tipResource = TipResource::make($tip);
        $data = [
            'message' => 'Se ha actualizado el tip correctamente',
            'tip' => $tipResource,
            'code' => 200,
        ];
        return response()->json($data);
    }
}
