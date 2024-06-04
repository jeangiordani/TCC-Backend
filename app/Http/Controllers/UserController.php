<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Mock;

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
            ', [$user]);
    
            $stats = [];
    
            foreach ($results as $row) {
                $knowledgeArea = $row->knowledge_area;
                $isCorrect = $row->is_correct;
                $count = $row->count;
    
                if (!isset($stats[$knowledgeArea])) {
                    $stats[$knowledgeArea] = [
                        'correct' => 0,
                        'incorrect' => 0,
                    ];
                }
    
                if ($isCorrect) {
                    $stats[$knowledgeArea]['correct'] += $count;
                } else {
                    $stats[$knowledgeArea]['incorrect'] += $count;
                }
            }
    
            return response()->json($stats);
        
    }
}
