<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipResource;
use App\Models\Tip;

class TipIndexController extends Controller
{
    public function index()
    {
        $tips = Tip::orderBy('id', 'DESC')
            ->paginate(10);
        return TipResource::collection($tips);
    }

    public function indexActive()
    {
        $blogs = Tip::where('is_active', true)
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return TipResource::collection($blogs);
    }

}
