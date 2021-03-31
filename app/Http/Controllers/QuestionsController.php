<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Using query log to access database
        // \DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(5);
        return view('questions.index', compact('questions'));
        // view('questions.index', compact('questions'))->render();
        // using die and dump
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
        $question = new Question();

        return view('questions.create', compact('question'));
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
        // get the current unserialize
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', "Your question has been submitted");

        //alternative redirect
        // return redirect('/questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      // long way of writing incrementing the views on a question
      // $question->views = $question->views + 1;
      // $question->save();

      // short form for incrmenting the view
      $question->increment('views');

      return view('questions.show', compact('question'));

        // dd($question->body);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // using the gate defined in AuthServiceProvider
        if(\Gate::denies('update-question', $question)){
          abort(403, "Access Denied");
        }
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        //
        if(\Gate::denies('update-question', $question)){
          abort(403, "Access Denied");
        }
        $question->update($request->only('title', 'body'));

        return redirect('/questions')->with('success', "Your question has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        if(\Gate::denies('delete-question', $question)){
          abort(403, "Access Denied");
        }
        $question->delete();
        return redirect('/questions')->with('success', "Your question has been deleted");
    }
}
