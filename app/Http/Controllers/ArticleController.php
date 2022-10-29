<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function render(Request $request) 
    {
        return view('index');
    }

    public function index(ArticleService $service)
    {
        return response()->json($service->getAll());
    }
}
