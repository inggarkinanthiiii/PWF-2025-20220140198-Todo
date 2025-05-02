<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TodoController extends Controller
{
    /**
     * Display a listing of the user's todos.
     */
    public function index()
    {
        $userId = auth()->id();

        $todos = Todo::where('user_id', $userId)
            ->orderBy('is_done')
            ->orderByDesc('created_at')
            ->get();

        $todosCompleted = Todo::where('user_id', $userId)
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created todo in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Todo::create([
            'title' => Str::title($request->title),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);

        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified todo in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::findOrFail($id);

        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        $todo->update([
            'title' => Str::title($request->title),
        ]);

        session(['edited_todo' => $id]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully.');
    }

    /**
     * Remove the specified todo from storage.
     */
    public function destroy(Todo $todo)
    {
        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        $todo->delete();

        return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
    }

    /**
     * Mark the todo as completed.
     */
    public function complete(Todo $todo)
    {
        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        $todo->update(['is_done' => true]);

        return redirect()->route('todo.index')->with('success', 'Todo completed successfully.');
    }

    /**
     * Mark the todo as not completed.
     */
    public function uncomplete(Todo $todo)
    {
        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        $todo->update(['is_done' => false]);

        return redirect()->route('todo.index')->with('success', 'Todo marked as incomplete.');
    }

    /**
     * Remove all completed todos for the authenticated user.
     */
    public function destroyCompleted()
    {
        Todo::where('user_id', auth()->id())
            ->where('is_done', true)
            ->delete();

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}
