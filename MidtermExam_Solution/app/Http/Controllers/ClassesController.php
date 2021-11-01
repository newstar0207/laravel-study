<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClassesController extends Controller
{
    public function create()
    {
        return Inertia::render('CreateClass');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'credit' => 'required|numeric'
        ]);

        $subject = new Subject;
        $subject->name = $request->name;
        $subject->description = $request->description;
        $subject->credit = $request->credit;
        $subject->save();

        return Redirect::route('classes.index');
    }

    public function index()
    {
        return Inertia::render('ClassList', ['Subjects' => fn () => Subject::latest()->paginate(10)]);
    }

    public function show($id)
    {
        $subject = Subject::find($id);
        return Inertia::render('Components.ShowClass', ['subject' => $subject]);
    }
}
