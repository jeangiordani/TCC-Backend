<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Mock;

class UserController extends Controller
{
    public function stats(){
        $user = auth()->user()->id;
        $mockExams = DB::table('mock_answers')
        ->join('mock_exams', 'mock_answers.mock_exam_id', '=', 'mock_exams.id')
        ->join('questions', 'mock_answers.question_id', '=', 'questions.id')
        ->join('knowledge_areas', 'questions.knowledge_area_id', '=', 'knowledge_areas.id')
        ->where('mock_exams.user_id', $user)
        ->whereNotNull('mock_answers.alternative_id')
        ->select('knowledge_areas.name', 'mock_answers.is_correct', DB::raw('count(*) as total'))
        ->groupBy('knowledge_areas.name', 'mock_answers.is_correct')
        ->orderBy('total', 'desc')
        ->get();

        $stats = collect($mockExams)->map(function($mockExam){
            $mockExam->is_correct = $mockExam->is_correct ? 'Correta' : 'Errada';
            return $mockExam;
        });

        dd($mockExams);
        
    }
}
