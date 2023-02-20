@extends('layouts.app')

@section('main_content')
    <body>
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4">Statistic Results</h1>

        <!-- Task 1 Table -->
        @include('tasks.task1')
        <!-- Task 2 Table -->
        @include('tasks.task2')
        <!-- Task 3 Table -->
        @include('tasks.task3')
    </div>
    </body>
@endsection
