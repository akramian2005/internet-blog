<?php

namespace App\Http\Controllers;

use App\Models\Article;

class MainController extends Controller
{
    public function index() {
        $articles = Article::latest()->paginate(6); 
        return view('index', compact('articles'));
    }
}

