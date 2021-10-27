<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Take;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TakeController extends Controller
{
    public function index(User $user)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subject $subject)
    {
        // dd($subject);
        $take = new Take;
        $take->user_id = Auth::user()->id;
        $take->subject_id = $subject->id;
        $take->save();


        return Inertia::render('Subject/Show', ['user' => Auth::user(), 'subject' => $subject, 'take' => $take]);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject, User $user)
    {
        $take  = DB::table('users')->where('user_id', $user->id)->where('subject_id', $subject->id)->get();
        dd($take);
    }
}
