@extends('layouts.app')
@section('title', $task->title)
@section('content')
    <p class="text-slate-600 text-md mx-3 my-5">{{ $task->description }}</p>
    @if ($task->long_description)
        <p class="text-slate-600 text-md mx-3 my-5">{{ $task->long_description }}</p>
    @endif
    <div class="flex justify-center gap-4 mb-5">
        <p class="text-green-500">{{ $task->created_at }}</p>
        <p class="text-blue-500">{{ $task->updated_at }}</p>
    </div>

    <div class="mx-3 mb-5">
        <a class="font-medium text-gray-700 underline decoration-pink-500 mb-1 capitalize text-xl"
            href="{{ route('tasks.edit', ['task' => $task->id]) }}">Edit</a>
    </div>
    <div>
        <form method="POST" action="{{ route('tasks.toggle-complete', ['task' => $task->id]) }}">
            @csrf
            @method('PUT')
            <button type="submit" @class([" mx-3 ","border border-blue-400 hover:bg-blue-300 rounded-md p-1 bg-blue-100"=>!$task->completed,
            "border border-red-400 hover:bg-red-300 rounded-md p-1 bg-red-100"=>$task->completed])>
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>

    </div>
    <div>
        <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="post">
            @method('DELETE ')
            @csrf
            <button class=" mx-3 border border-orange-400 hover:bg-orange-300 rounded-md p-1 bg-orange-100" type="submit">Delete</button>
        </form>
    </div>
@endsection
