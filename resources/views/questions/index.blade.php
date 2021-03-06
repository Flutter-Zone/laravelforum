@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">
                                    Ask Question
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @include ('layouts._messages')
                    @foreach ($questions as $question)
                        <div class='media'>
                            <div class="d-flex flex-column counters">
                                <div class="vote">
                                    <strong>{{ $question->votes }}</strong> {{ \Illuminate\Support\Str::plural('vote', $question->votes) }}
                                </div>
                                <div class="status {{ $question->status }}">
                                    <strong>{{ $question->answers_count }}</strong> {{ \Illuminate\Support\Str::plural('answer', $question->answers_count) }}
                                </div>
                                <div class="view">
                                    {{ $question->views ." ". \Illuminate\Support\Str::plural('view', $question->views) }}
                                </div>
                            </div>
                            <div class='media-body'>
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                    <div class='ml-auto'>
                                        @can('update', $question)
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">
                                            Edit
                                        </a>
                                        @endcan

                                        @can('delete', $question)
                                        <form class="form-delete" method='POST' action="{{ route('questions.destroy', $question->id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onClick="return confirm('Are you sure you want to delete question?')">Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                                <p class="lead">
                                    Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                    <small class='text-muted'>{{ $question->created_date }}</small>
                                </p>
                                {{ \Illuminate\Support\Str::limit($question->body, 250) }}
                            </div>
                        </div>
                        <hr/>
                    @endforeach

                    <div class="justify-content-center">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
