<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{

    public function __construct(){
        // calling the authentication middleware
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // \DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(10);

        return view('questions.index', compact('questions'));

        // dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $questions = new Question();

        return view('questions.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        //
        $request->user()->questions()->create($request->only('title', 'body'));

        // return redirect('/questions');
        return redirect()->route('questions.index')->with('success', "Your question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //$question->views = $question->views + 1;
        $question->increment('views');

        return view('questions.show', compact('question'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        if(Auth::user()->cannot('update', $question)){
            return redirect()->route('questions.index');
        }
        return view("questions.edit", compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        //
        if(Auth::user()->cannot('update', $question)){
            abort(403, "Access denied for this user");
        }
        $question->update($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        
        if(Auth::user()->cannot('delete', $question)){
            abort(403, "Access denied for this user");
        }
        $question->delete();
        return redirect()->route('questions.index')->with('success', "Your question has been deleted");
    }
}
