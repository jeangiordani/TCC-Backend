<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArea;
use Illuminate\Http\Request;

class KnowledgeAreaController extends Controller
{
    public function index()
    {
        return response()->json(KnowledgeArea::all());
    }
}
