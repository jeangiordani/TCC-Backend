<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\KnowledgeArea;
use App\Models\MockExam;
use App\Models\MockExamAnswer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockExamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:45',
            'description' => 'max:255',
            'qty_questions' => 'required|integer',
            'user_id' => 'exists:users,id|required|integer',
            'knowledge_area_id' => 'integer'
        ]);

        if($request->knowledge_area_id){
            $knowledgeArea = KnowledgeArea::find($request->knowledge_area_id);
            if(!$knowledgeArea){
                return response()->json([
                    'message' => 'Área de conhecimento não encontrada.',
                ], 404);
            }
        }

        $qtyQuestions = $request->qty_questions;

        if ($qtyQuestions < 1 || $qtyQuestions > 90) {
            return response()->json([
                'message' => 'A quantidade de questões deve ser entre 1 e 90.',
            ], 400);
        }

        if(!$request->knowledge_area_id){
            
            $knowledgeAreas = KnowledgeArea::where('is_active', true)->get();
        }else{
            $knowledgeAreas = KnowledgeArea::where('id', $request->knowledge_area_id)->get();
        }


        $numKnowledgeAreas = $knowledgeAreas->count();
        $questionsPerArea = intdiv($qtyQuestions, $numKnowledgeAreas);
        $extraQuestions = $qtyQuestions % $numKnowledgeAreas;

        $selectedQuestions = collect();

        foreach ($knowledgeAreas as $index => $knowledgeArea) {
            $numQuestions = $questionsPerArea + ($index < $extraQuestions ? 1 : 0);

            $questions = Question::where('knowledge_area_id', $knowledgeArea->id)
                ->where('is_active', true)
                ->inRandomOrder()
                ->take($numQuestions)
                ->get();

            // if ($questions->count() < $numQuestions) {
            //     return response()->json([
            //         'error' => 'Não a questões suficiente: ' . $knowledgeArea->name,
            //     ], 400);
            // }

            $selectedQuestions = $selectedQuestions->merge($questions);
        }

        $mockExam = MockExam::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'qty_questions' => $qtyQuestions,
            'knowledge_area_id' => null, 
            'user_id' => $request->input('user_id'),
        ]);

        foreach ($selectedQuestions as $question) {
            $mockExam->answers()->create([
                'question_id' => $question->id,
                'is_correct' => false, 
                'alternative_id' => null,
            ]);
        }

        return response()->json([
            'message' => 'Simulado criado com sucesso!',
            'data' => $mockExam,
        ], 201);
    }

    public function index(Request $request)
    {   
        $mockExams = $request->user()->mockExams()->withCount([
            'answers',
            'answers as qty_answered' => function ($query) {
                $query->whereNotNull('alternative_id');
            }
        ])->get();
        

        return response()->json([
            'data' => $mockExams,
        ]);
    }

    public function show($id)
    {
        $mockExam = MockExam::with([
            'answers.question.alternatives',
            'answers.question.image'
        ])->find($id);

        if (!$mockExam) {
            return response()->json([
                'error' => 'Simulado não encontrado!',
            ], 404);
        }

        $data = [
            'mock_exam' => [
                'id' => $mockExam->id,
                'title' => $mockExam->title,
                'description' => $mockExam->description,
                'qty_questions' => $mockExam->qty_questions,
                'user_id' => $mockExam->user_id,
                'created_at' => $mockExam->created_at,
                'updated_at' => $mockExam->updated_at,
            ],
            'questions' => $mockExam->answers->map(function ($answer) {
                $question = $answer->question;
                return [
                    'id' => $question->id,
                    'statement' => $question->statement,
                    'post_statement' => $question->post_statement,
                    'is_active' => $question->is_active,
                    'knowledge_area_id' => $question->knowledge_area_id,
                    'knowledge_area' => $question->knowledge_area->name,
                    'alternatives' => $question->alternatives->map(function ($alternative) {
                        return [
                            'id' => $alternative->id,
                            'letter' => $alternative->letter,
                            'description' => $alternative->description,
                            'is_correct' => $alternative->is_correct,
                        ];
                    }),
                    'image' => $question->image ? $question->image->path : null,
                    'answer' => [
                        'id' => $answer->id,
                        'is_correct' => $answer->is_correct,
                        'alternative_id' => $answer->alternative_id,
                    ],
                    'comments' => $question->comments->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'text' => $comment->text,
                            'user_id' => $comment->user_id,
                            'question_id' => $comment->question_id,
                            'created_at' => $comment->created_at,
                            'updated_at' => $comment->updated_at,
                        ];
                    }),
                ];
            }),
        ];
        return response()->json($data);
    }
    
    public function markAnswer(Request $request, $answerId)
    {
        $request->validate([
            'alternative_id' => 'required|exists:alternatives,id',
        ]);

        $mockExamAnswer = MockExamAnswer::find($answerId);

        if (!$mockExamAnswer) {
            return response()->json([
                'error' => 'Answer not found',
            ], 404);
        }

        $alternative = Alternative::find($request->input('alternative_id'));

        $mockExamAnswer->alternative_id = $alternative->id;
        $mockExamAnswer->is_correct = $alternative->is_correct;
        $mockExamAnswer->save();
        

        return response()->json([
            'message' => 'Resposta marcada com sucesso!',
            'answer' => $mockExamAnswer,
        ], 200);
    }
    
}
