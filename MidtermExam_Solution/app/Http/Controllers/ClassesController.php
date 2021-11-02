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
        // $subject = Subject::find($id);
        // return Inertia::render('Components/ShowClass', ['subject' => $subject]);

        return Inertia::render(
            'ShowClass',
            [
                'subject' => fn () => Subject::find($id),
                'registeredClass' => fn () => auth()->user()->subjects->contains($id),
                //contains 메소드는 주어진 모델 인스턴스가 컬렉션에 포함되어 있는지를 결정하는데 사용될 수 있습니다. 이 메소드는 기본-primary 키 또는 모델 인스턴스를 허용합니다
                // subjects => user모델에 있는 메소드
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'credit' => 'required|numeric'
        ]);

        $subject = Subject::find($id);
        $subject->name = $request->name;
        $subject->credit = $request->credit;
        $subject->description = $request->description;

        $subject->save();

        return Redirect::route('classes.show', ['classId' => $id]);
    }

    public function destroy($id)
    {
        $subject = Subject::find($id);

        $subject->delete();

        return Redirect::route('classes.index');
    }

    public function register($id)
    {
        auth()->user()->subjects()->toggle($id);

        return Redirect::route('classes.show', ['classId' => $id]);
    }

    public function index_cr()
    {
        return Inertia::render('ClassesRegistered', ['subjects' => fn () => auth()->user()->subjects]);
    }
}
