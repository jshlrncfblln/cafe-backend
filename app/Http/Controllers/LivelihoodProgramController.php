<?php

namespace App\Http\Controllers;

use App\Models\LivelihoodProgram;
use App\Models\LivelihoodPrograms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LivelihoodProgramController extends Controller
{
    public function index()
    {
        return LivelihoodPrograms::all();
    }

    public function show($id)
    {
        return LivelihoodPrograms::find($id);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return LivelihoodPrograms::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $livelihood = LivelihoodPrograms::find($id);

        if (!$livelihood) {
            abort(404, 'Livelihood Program not found');
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $livelihood->name = $request->name;
        $livelihood->description = $request->description;
        $livelihood->updated_by = $user->id;
        $livelihood->save();

        return $livelihood;
    }

    public function destroy($id)
    {
        $livelihood = LivelihoodPrograms::find($id);

        if (!$livelihood) {
            abort(404, 'Livelihood Program not found');
        }

        $livelihood->delete();

        return response()->json(['message' => 'Livelihood Program deleted successfully']);
    }
}