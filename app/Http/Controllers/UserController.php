<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function stats()
        {
            $user = auth()->user()->id;
    
            $results = DB::select('
                SELECT 
                    ka.name AS knowledge_area,
                    ma.is_correct,
                    COUNT(*) AS count
                FROM mock_answers ma
                INNER JOIN mock_exams me ON ma.mock_exam_id = me.id
                INNER JOIN questions q ON ma.question_id = q.id 
                INNER JOIN knowledge_areas ka ON q.knowledge_area_id = ka.id 
                WHERE me.user_id = ? AND ma.alternative_id IS NOT NULL
                GROUP BY ka.name, ma.is_correct
                ORDER BY ka.name, ma.is_correct
            ', [$user]);
    
            $formattedResults = [];
            $data = [];

            foreach ($results as $result) {
                $knowledge_area = $result->knowledge_area;
                $is_correct = $result->is_correct;
                $count = $result->count;

                if (!isset($data[$knowledge_area])) {
                    $data[$knowledge_area] = [
                        'subject' => $knowledge_area,
                        'correct' => 0,
                        'incorrect' => 0,
                    ];
                }

                if ($is_correct) {
                    $data[$knowledge_area]['correct'] += $count;
                } else {
                    $data[$knowledge_area]['incorrect'] += $count;
                }
            }

            foreach ($data as $item) {
                $formattedResults[] = $item;
            }

            return response()->json($formattedResults);
        
    }
}
