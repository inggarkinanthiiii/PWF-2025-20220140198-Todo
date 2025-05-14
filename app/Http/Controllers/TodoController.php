<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category; // Import the Category model
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

        // Eager load the category relationship to avoid n+1 query problem
        $todos = Todo::with('category')->get();

        $todos = Todo::with('category')
            ->where('user_id', $userId)
            ->orderBy('is_done')
            ->orderByDesc('created_at')
            ->paginate(10); // Use paginate for better performance

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
        // Fetch categories from the database to populate the dropdown
        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }

    /**
     * Store a newly created todo in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id', // Validate that the category_id exists in the categories table
        ]);

        Todo::create([
            'title' => Str::title($request->title),
            'status' => $request->status,
            'user_id' => auth()->id(),
            'is_done' => $request->is_done ?? 0,
            'category_id' => $request->category_id, // Store the category_id
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        $categories = Category::all();
        $todo = Todo::with('category')->findOrFail($id); // Eager load category for edit form
        $categories = Category::all(); // Fetch all categories for the dropdown
        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        return view('todo.edit', compact('todo', 'categories')); // Pass categories to the view
    }

    /**
     * Update the specified todo in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id', // Validate category_id
        ]);

        $todo = Todo::findOrFail($id);

        abort_if($todo->user_id !== auth()->id(), 403, 'Unauthorized');

        $todo->update([
            'title' => Str::title($request->title),
            'status' => $request->status,
            'is_done' => $request->is_done ?? 0,
            'category_id' => $request->category_id, // Update the category_id
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

