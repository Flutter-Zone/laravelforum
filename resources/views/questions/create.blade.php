@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <h2>Ask Question</h2>
                    </div>
                    <div class="float-right">
                        <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">
                            Back to All Questions
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('questions.store') }}" method="POST">
                       @include("questions._form", ['buttonText'=>"Ask Question"])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
