<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\Category;
use App\Models\Chart;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BracketController extends Controller
{
    //
    public function bracket(Request $request)
    {
        try {
            $query = Category::where('has_bracket', '=', 1);
            if ($request->has('tournament_id')) {
                $query->where('tournament_id', '=', $request->tournament_id);
            }
            $chart = $query->get();
            return Response::json([
                'data' => $chart,
                'status_code' => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail get bracket',
                'message' => $e
            ], 500);
        }
    }

    public function detail(Request $request)
    {
        if (isset($request->id)) {
            try {
                $chart = Bracket::select('brackets.*', 'c.category_name')
                    ->where('category_id', '=', $request->id)
                    ->join('categories as c', 'c.id', 'brackets.category_id')
                    ->first();
                return Response::json([
                    'data' => $chart,
                    'status_code' => 200
                ], 200);
            } catch (Exception $e) {
                return Response::json([
                    'error' => 'Fail get bracket',
                    'message' => $e
                ], 500);
            }
        }
    }

    public function saveBracket(Request $request)
    {
        $request->validate([
            'martial_id' => 'required',
            'category_name' => 'required',
            'bracket' => 'required',
            'games' => 'required',
        ]);

        $tournament = null;
        if ($request->tournament_id != null) {
            $tournament = Tournament::where('id', '=', $request->tournament_id)->first();
        } else {
            $tournament = Tournament::where('martial_id', $request->martial_id)
                                    ->where('tournament_name', $request->tournament_name)
                                    ->first();
            if (!$tournament) {
                $tournament = Tournament::create([
                    'martial_id' => $request->martial_id,
                    'tournament_name' => $request->tournament_name,
                ]);
            }
        }

        $category = Category::create([
            'tournament_id' => $tournament->id,
            'category_name' => $request->category_name,
            'has_bracket' => 1,
            'actived' => 1,
        ]);

        try {
            foreach ($request->games as $c) {
                Chart::create([
                    'martial_id'    => $request->martial_id,
                    'tournament_id' => $tournament->id,
                    'category_id'   => $category->id,
                    'red_name'      => $c['red_name'],
                    'red_club'      => $c['red_club'],
                    'blue_name'     => $c['blue_name'],
                    'blue_club'     => $c['blue_club'],
                    'match_number'  => $c['match_number'],
                    'play_now'      => 0
                ]);
            }
        } catch (Exception $err) {
            return Response::json([
                'error' => 'Fail make Chart',
                'message' => $err
            ], 500);
        }

        try {
            Bracket::create([
                'category_id'   => $category->id,
                'brackets' => $request->bracket,
            ]);
        } catch (Exception $err) {
            return Response::json([
                'error' => 'Fail make Bracket',
                'message' => $err
            ], 500);
        }

        return Response::json([
            'message' => 'Data berhasil ditambahkan',
            'tournament_id' => $tournament->id,
            'status_code' => 200
        ], 200);
    }

    public function editBracket(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'bracket' => 'required',
        ]);

        $bracket = Bracket::where('id', $request->id)->first();

        if (isset($bracket)) {

            $bracket->update([
                'brackets' => $request->bracket
            ]);
            return Response::json([
                'message' => 'Data successfuly updated',
                'status_code' => 200
            ], 200);
        }

        return Response::json([
            'error' => 'Fail make Bracket',
            'message' => 'Bracket not found'
        ], 400);
    }
}
