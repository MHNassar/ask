<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\User;
use App\Question;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $quesCount = Question::count();
        $ansQuesCount = Question::has('answer')->count();
        $categories = Category::with(['users', 'questions'])->get();
        $users = User::whereType(1)->withCount('answers')->orderByDesc('answers_count')->limit(3)->get();

        return view('report.index')->with('quesCount', $quesCount)
            ->with('ansQuesCount', $ansQuesCount)->with('categories', $categories)->with('users', $users);
    }
}
