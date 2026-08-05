<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipStoreRequest;
use App\Models\Tip;
use App\Http\Resources\TipResource;

class TipStoreController extends Controller
{

    public function store(TipStoreRequest $tipStoreRequest)
    {
        $tip = New Tip();
        $tip->title = $tipStoreRequest->title;
        $tip->description = $tipStoreRequest->description;
        $tip->is_active = true;
        $tip->save();

        $tipResource = TipResource::make($tip);
        $data = [
            'message' => 'Se ha creado el tip correctamente',
            'tip' => $tipResource,
            'code' => 200,
        ];
        return response()->json($data);
    }
}
