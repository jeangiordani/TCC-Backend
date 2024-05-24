<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use App\Models\User;
use Illuminate\Http\Request;

class MockExamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:45',
            'description' => 'required',
            'qty_questions' => 'required|integer',
            'user_id' => 'exists:users,id|required|integer',
            'knowledge_area_id' => 'exists:knowledge_areas,id|required|integer'
        ]);

        $mockExam = new MockExam();
        $mockExam->title = $request->title;
        $mockExam->description = $request->description;
        $mockExam->qty_questions = $request->qty_questions;
        $mockExam->user_id = $request->user_id;
        $mockExam->knowledge_area_id = $request->knowledge_area_id;
        // $mockExam->save();

        return response()->json([
            'message' => 'Simulado criado com sucesso!',
            'data' => $mockExam,
        ], 201);
    }

    public function index()
    {
        $mockExams = MockExam::all();

        return response()->json([
            'data' => $mockExams,
        ]);
    }
}
