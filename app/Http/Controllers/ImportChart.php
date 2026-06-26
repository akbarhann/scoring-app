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

    public function parseRecipe(Request $request)
    {
        $request->validate([
            'preview' => 'required|array',
        ]);

        $keysString = env('GROQ_API_KEYS', '');
        $apiKeys = array_filter(array_map('trim', explode(',', $keysString)));
        if (empty($apiKeys)) {
            $apiKeys = [env('GROQ_API_KEY')];
        }

        if (empty($apiKeys[0])) {
            return Response::json([
                'status' => 'error',
                'message' => 'Groq API Key is not configured in .env'
            ], 500);
        }

        $maxAttempts = count($apiKeys);
        $response = null;
        $errorMsg = '';

        $systemPrompt = "You are an expert Excel layout analyzer. Your job is to analyze the provided Excel sheet preview rows and return a JSON recipe on how to parse it.\n"
            . "Determine:\n"
            . "1. Which row index is the table header (the row containing column names like 'nama', 'club', 'atlet', 'klub', etc.)?\n"
            . "2. What are the column indexes for the athlete's name, club, gender, age, weight, and match type/category? If a column is missing, set its index to -1.\n"
            . "3. Does the sheet contain vertically stacked tables (sub-categories within the sheet separated by titles or empty rows)? If yes, set 'has_stacked_tables' to true, and specify how to detect the sub-category title row index or pattern.\n\n"
            . "Return strictly a JSON object matching this schema:\n"
            . "{\n"
            . "  \"status\": \"success\",\n"
            . "  \"header_row_index\": 3,\n"
            . "  \"column_mapping\": {\n"
            . "    \"name_column_index\": 1,\n"
            . "    \"club_column_index\": 2,\n"
            . "    \"gender_column_index\": 3,\n"
            . "    \"age_column_index\": 4,\n"
            . "    \"weight_column_index\": 5,\n"
            . "    \"match_type_column_index\": 6\n"
            . "  },\n"
            . "  \"segmentation\": {\n"
            . "    \"has_stacked_tables\": true,\n"
            . "    \"category_title_indicator\": {\n"
            . "      \"row_index\": 1,\n"
            . "      \"cell_index\": 3,\n"
            . "      \"pattern\": \"KATEGORI:\"\n"
            . "    }\n"
            . "  }\n"
            . "}";

        for ($i = 0; $i < $maxAttempts; $i++) {
            $apiKey = $apiKeys[$i];
            
            try {
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-specdec',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "Here is the JSON preview of the Excel worksheet:\n\n" . json_encode($request->preview, JSON_PRETTY_PRINT)]
                    ],
                    'temperature' => 0.0,
                    'response_format' => ['type' => 'json_object']
                ]);

                if ($response->status() === 429) {
                    continue;
                }

                if ($response->successful()) {
                    $content = json_decode($response->json()['choices'][0]['message']['content'], true);
                    return Response::json([
                        'status' => 'success',
                        'recipe' => $content
                    ]);
                } else {
                    $errorMsg = $response->body();
                }
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
            }
        }

        return Response::json([
            'status' => 'error',
            'message' => 'Failed to reach Groq API or all keys exhausted. Details: ' . $errorMsg
        ], 500);
    }
}

