<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chart;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Response;

class GamesController extends Controller
{
    //
    public function list()
    {
        try {
            $chart = Chart::where('category_id', '=', $_GET['category_id'])->orderBy('match_number', 'ASC')->get();
            $category = Category::where('id', '=', $_GET['category_id'])->first();
            $tournament = Tournament::where('id', '=', $category->tournament_id)->first();
            foreach ($chart as $c) {
                $game = Game::where('chart_id', '=', $c->id)->first();
                $c->game = $game;
            }
            return Response::json([
                'data'          => $chart,
                'category'      => $category,
                'tournament'    => $tournament,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail get participants',
                'message' => $e
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'martial_id' => 'required',
            'tournament_id' => 'required',
            'category_id' => 'required',
            'match_number' => 'required',
        ]);

        try {
            $chart = Chart::create([
                'martial_id' => $request->martial_id,
                'tournament_id' => $request->tournament_id,
                'category_id' => $request->category_id,
                'red_name' => $request->red_name,
                'red_club' => $request->red_club,
                'blue_name' => $request->blue_name,
                'blue_club' => $request->blue_club,
                'match_number' => $request->match_number,
                'play_now' => 0,
            ]);
            return Response::json([
                'participant'   => $chart,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail edit player',
                'message' => $e
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $chart = Chart::where('id', '=', $request->id)->first();
            $chart->update([
                'red_name' => $request->red_name,
                'red_club' => $request->red_club,
                'blue_name' => $request->blue_name,
                'blue_club' => $request->blue_club,
                'match_number' => $request->match_number
            ]);
            return Response::json([
                'participant'   => $chart,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail edit player',
                'message' => $e
            ], 500);
        }
    }

    public function delete()
    {
        try {
            $chart = Chart::where('id', '=', $_GET['id'])->first();
            $game = Game::where('chart_id', '=', $chart->id)->first();
            if ($game != null) {
                $game->delete($game);
            }
            $chart->delete($chart);

            return Response::json([
                'message'   => 'Data deleted',
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail delete data',
                'message' => $e
            ], 500);
        }
    }

    public function detail()
    {
        try {
            $participant = Chart::where('id', '=', $_GET['chart_id'])->first();
            $tournament = Tournament::where('id', '=', $participant->tournament_id)->first();
            $category = Category::where('id', '=', $participant->category_id)->first();
            $game = Game::where('chart_id', '=', $_GET['chart_id'])->first();

            return Response::json([
                'participant'   => $participant,
                'tournament'    => $tournament,
                'category'      => $category,
                'game'          => $game,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            dd($e);
            return Response::json([
                'error' => 'Fail get detail',
                'message' => $e
            ], 500);
        }
    }

    public function play(Request $request)
    {
        try {
            $participant = Chart::where('id', '=', $request->chart_id)->first();
            $participant->update([
                'play_now' => 1
            ]);

            $game = null;
            $game = Game::where('chart_id', '=', $request->chart_id)->first();
            if ($game == null) {
                $game = Game::create([
                    'chart_id'      => $request->chart_id,
                    'scoring_type'  => $request->scoring_type
                ]);
            }

            $tournament = Tournament::where('id', '=', $participant->tournament_id)->first();
            $category = Category::where('id', '=', $participant->category_id)->first();

            return Response::json([
                'participant'   => $participant,
                'game'          => $game,
                'tournament'    => $tournament,
                'category'      => $category,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail post play',
                'message' => $e
            ], 500);
        }
    }

    public function control_active(Request $request)
    {
        try {
            $current_part = Chart::where('id', '=', $request->current_chart_id)->first();
            $participant = Chart::where('id', '=', $request->chart_id)->first();
            $participant->update([
                'actived' => 1
            ]);
            $current_part->update([
                'actived' => 0,
            ]);

            if ($current_part->play_now == 1) {
                $current_part->update([
                    'play_now' => 2
                ]);
            }

            $tournament = Tournament::where('id', '=', $participant->tournament_id)->first();
            $category = Category::where('id', '=', $participant->category_id)->first();

            return Response::json([
                'participant'   => $participant,
                'tournament'    => $tournament,
                'category'      => $category,
                'status_code'   => 200
            ], 200);
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail post next',
                'message' => $e
            ], 500);
        }
    }

    public function save(Request $request)
    {
        try {
            $participant = Chart::where('id', '=', $request->chart_id)->first();
            $game = Game::where('id', '=', $request->game_id)->first();

            $participant->update([
                'play_now'      => 2,
                'winner'        => $request->winner,
                'disqualified'  => $request->disqualified
            ]);

            $game->update([
                'red_points' => $request->red_point,
                'red_foul' => $request->red_foul,
                'blue_points' => $request->blue_point,
                'blue_foul' => $request->blue_foul,
            ]);

            $temp_match = $participant->match_number + 1;
            $temp_winner = null;
            if ($request->winner == 1) {
                $temp_winner = [
                    'name' => $participant->red_name,
                    'club' => $participant->red_club,
                ];
            } else {
                $temp_winner = [
                    'name' => $participant->blue_name,
                    'club' => $participant->blue_club,
                ];
            }

            $all_participant = Chart::where('category_id', '=', $participant->category_id)->get();
            $isset = false;
            foreach ($all_participant as $p) {
                if (!$isset) {
                    if ($participant->order_code != null && $participant->order_code > 0) {
                        if ($participant->order_code == $p->order_code) {
                            if ($p->red_name == null) {
                                $p->update([
                                    'red_name' => $temp_winner['name'],
                                    'red_club' => $temp_winner['club'],
                                    'order_code' => null
                                ]);
                                $isset = true;
                            } else if ($p->blue_name == null) {
                                $p->update([
                                    'blue_name' => $temp_winner['name'],
                                    'blue_club' => $temp_winner['club'],
                                    'order_code' => null
                                ]);
                                $isset = true;
                            }
                        }
                    } else if ($p->match_number == $temp_match) {
                        if ($p->red_name == null) {
                            $p->update([
                                'red_name' => $temp_winner['name'],
                                'red_club' => $temp_winner['club'],
                            ]);
                            $isset = true;
                        } else if ($p->blue_name == null) {
                            $p->update([
                                'blue_name' => $temp_winner['name'],
                                'blue_club' => $temp_winner['club'],
                            ]);
                            $isset = true;
                        }
                    }
                }
            }
            if (!$isset) {
                Chart::create([
                    'martial_id'    => $participant->martial_id,
                    'tournament_id' => $participant->tournament_id,
                    'category_id'   => $participant->category_id,
                    'red_name'      => $temp_winner['name'],
                    'red_club'      => $temp_winner['club'],
                    'match_number'  => $temp_match,
                    'play_now'      => 0,
                    'actived'       => 0,
                ]);
            }
        } catch (Exception $e) {
            return Response::json([
                'error' => 'Fail next',
                'message' => $e
            ], 500);
        }
    }
}
