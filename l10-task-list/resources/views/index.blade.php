@extends('layouts.app')
@section('title', 'TO DO LISTS')
@section('content')
    <nav class="mb-4">
        <a
            class="font-medium text-gray-700 underline decoration-pink-500 mb-1 capitalize text-xl" 
            href="{{ route('tasks.create') }}">
            addtask
        </a>
    </nav>
    @forelse ($tasks as $task)
        <div>
            <a 
            @class(['font-bold text-slate-500 hover:text-pink-300 border-b-2 border-pink-700','line-through' => $task->completed])
            href="{{ route('tasks.show', ['task' => $task->id]) }}">
                {{ $task->title }}</a>
        </div>

    @empty
        <div>Empty</div>
    @endforelse
    @if ($tasks->count())
        <nav class="mt-4 ">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
