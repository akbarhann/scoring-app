<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Martial;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class ItemSelect extends Controller
{
    //
    public function martial()
    {
        $martial = Martial::get();
        return Response::json([
            'data'          => $martial,
            'status_code'   => 200
        ], 200);
    }

    public function tournament()
    {
        try {
            $tournament = Tournament::where('martial_id', '=', $_GET['martial_id'])->get();
            return Response::json([
                'data'          => $tournament,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail get tournament',
                'message' => $e
            ], 500);
        }
    }

    public function category()
    {
        try {
            $categories = Category::where('tournament_id', '=', $_GET['tournament_id'])->get();
            return Response::json([
                'data'          => $categories,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail get category',
                'message' => $e
            ], 500);
        }
    }

    public function deleteTournament(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $tournamentId = $request->id;

        try {
            DB::transaction(function () use ($tournamentId) {
                // Delete games associated with charts under this tournament
                $chartIds = DB::table('charts')->where('tournament_id', $tournamentId)->pluck('id');
                DB::table('games')->whereIn('chart_id', $chartIds)->delete();

                // Delete brackets associated with categories under this tournament
                $categoryIds = DB::table('categories')->where('tournament_id', $tournamentId)->pluck('id');
                DB::table('brackets')->whereIn('category_id', $categoryIds)->delete();

                // Delete charts under this tournament
                DB::table('charts')->where('tournament_id', $tournamentId)->delete();

                // Delete categories under this tournament
                DB::table('categories')->where('tournament_id', $tournamentId)->delete();

                // Delete tournament
                DB::table('tournaments')->where('id', $tournamentId)->delete();
            });

            return Response::json([
                'message' => 'Tournament successfully deleted',
                'status_code' => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail delete tournament',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
