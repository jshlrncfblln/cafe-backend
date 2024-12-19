<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChurchPrograms;
use Auth;

class ChurchProgramsController extends Controller
{
    //
    public function index()
    {
        return ChurchPrograms::all();
    }

    public function show($id)
    {
        return ChurchPrograms::find($id);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $churchProgram = ChurchPrograms::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        return $churchProgram;
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $churchProgram = ChurchPrograms::find($id);

        if (!$churchProgram) {
            abort(404, 'Church Program not found');
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $churchProgram->name = $request->name;
        $churchProgram->description = $request->description;
        $churchProgram->updated_by = $user->id;
        $churchProgram->save();

        return $churchProgram;
    }

    public function destroy($id)
    {
        $churchProgram = ChurchPrograms::find($id);

        if (!$churchProgram) {
            abort(404, 'Church Program not found');
        }

        $churchProgram->delete();

        return $churchProgram;
    }
}
