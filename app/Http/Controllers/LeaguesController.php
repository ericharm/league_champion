<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\League;

class LeaguesController extends Controller
{
  public function index() {
    $leagues = League::all();

    return response()->json([
      'leagues' => $leagues
    ], 200);
  }

  public function store(Request $request) {
    $league = League::create($request->all());

    return response()->json([
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
      'league' => $league
    ], 200);
  }

  public function update(Request $request, $id) {
    $league = League::findOrFail($id);
    $input = $request->all();
    $league->update($input);

    return response()->json([
      'league' => $league
    ], 202);
  }

  public function destroy($id) {
  }
}
