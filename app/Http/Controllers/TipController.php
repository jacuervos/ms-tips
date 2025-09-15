<?php

namespace App\Http\Controllers;
use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    public function index()
    {
        return response()->json(Tip::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'max_point' => 'required|integer',
            'min_point' => 'required|integer',
        ]);

        $tip = Tip::create($validated);
        return response()->json($tip, 201);
    }

    public function show(Tip $tip)
    {
        return response()->json($tip);
    }

    public function update(Request $request, Tip $tip)
    {
        $tip->update($request->all());
        return response()->json($tip);
    }

    public function destroy(Tip $tip)
    {
        $tip->delete();
        return response()->json(null, 204);
    }
}
