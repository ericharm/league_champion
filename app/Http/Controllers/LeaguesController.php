<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\League;

class LeaguesController extends Controller
{
    public function index() {
        $leagues = League::all();

        return response()->json([
            'status' => 'success',
            'leagues' => $leagues
        ], 200);
    }

    public function store(Request $request) {
        $league = League::create($request->all());

        return response()->json([
            'status' => 'success',
            'league' => $league
        ], 201);
    }

    public function show($id) {
        $league = League::find($id);

        if (!$league) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No league found with id ' . $id
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'league' => $league
        ], 200);
    }

    public function update(Request $request, $id) {
        $league = League::findOrFail($id);
        $input = $request->all();
        $league->update($input);

        return response()->json([
            'status' => 'success',
            'league' => $league
        ], 202);
    }

    public function destroy($id) {
        $league = League::find($id);
        $league->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'League \'' . $league->name . '\' successfully deleted.'
        ], 202);
    }
}
