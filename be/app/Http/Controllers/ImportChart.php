<?php

namespace App\Http\Controllers;

use App\Imports\ChartsImport;
use App\Models\Category;
use App\Models\Chart;
use App\Models\Tournament;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class ImportChart extends Controller
{
    //
    public function import(Request $request)
    {
        $request->validate([
            'martial_id' => 'required',
            'tournament_name' => 'required',
            'category_name' => 'required',
            'file_import' => 'required',
        ]);

        $charts = Excel::toCollection(new ChartsImport, $request->file('file_import'));
        try {
            $tournament = null;
            if ($request->tournament_id != null) {
                $tournament = Tournament::where('id', '=', $request->tournament_id)->first();
            } else {
                $tournament = Tournament::create([
                    'martial_id' => $request->martial_id,
                    'tournament_name' => $request->tournament_name,
                ]);
            }

            try {
                $category = Category::create([
                    'tournament_id' => $tournament->id,
                    'category_name' => $request->category_name,
                    'actived' => 1,
                ]);

                try {
                    foreach ($charts as $chart) {
                        foreach ($chart as $c) {
                            Chart::create([
                                'martial_id'    => $request->martial_id,
                                'tournament_id' => $category->tournament_id,
                                'category_id'   => $category->id,
                                'red_name'      => $c['red_name'],
                                'red_club'      => $c['red_club'],
                                'blue_name'     => $c['blue_name'],
                                'blue_club'     => $c['blue_club'],
                                'match_number'  => $c['match_number'],
                                'order_code'    => $c['order'],
                                'play_now'      => 0
                            ]);
                        }
                    }
                } catch (Exception $err) {
                    return Response::json([
                        'error' => 'Fail make Chart',
                        'message' => $err
                    ], 500);
                }
            } catch (Exception $e) {
                return Response::json([
                    'error' => 'Fail make Category',
                    'message' => $e
                ], 500);
            }
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail make Tournament',
                'message' => $e
            ], 500);
        }

        return Response::json([
            'data' => 'success',
        ], 201);
    }
}
