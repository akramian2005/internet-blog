<?php

namespace App\Http\Controllers;

use App\Models\Article;

class MainController extends Controller
{
    public function index() {
        $articles = Article::latest()->take(6)->get(); // последние статьи
        return view('index', compact('articles'));
    }
}
