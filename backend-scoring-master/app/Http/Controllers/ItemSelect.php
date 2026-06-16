<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Martial;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Response;


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
}
