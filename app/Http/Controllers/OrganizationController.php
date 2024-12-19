<?php

namespace App\Http\Controllers;

use App\Models\Organizations;
use Auth;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        return Organizations::all();
    }

    public function show($id)
    {
        return Organizations::find($id);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return Organizations::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $organization = Organizations::find($id);

        if (!$organization) {
            abort(404, 'Organization not found');
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $organization->name = $request->name;
        $organization->description = $request->description;
        $organization->updated_by = $user->id;
        $organization->save();

        return $organization;
    }

    public function destroy($id)
    {
        $organization = Organizations::find($id);

        if (!$organization) {
            abort(404, 'Organization not found');
        }

        $organization->delete();

        return response()->json(null, 204);
    }
}