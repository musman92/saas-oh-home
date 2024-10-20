<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
  public function index()
  {
    $todos = Todo::paginate(5);
    return view('todos.index', compact('todos'));
  }

  public function create()
  {
    return view('todos.create');
  }

  public function store(Request $request)
  {
    // Validate and store the data
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    // Create the todo
    $todo = new Todo();
    $todo->user_id = auth()->id();
    $todo->title = $validatedData['title'];
    $todo->description = $validatedData['description'];
    $todo->save();

    return redirect()->route('todos.index')->with('success', 'Todo created successfully.');
  }
  
  public function edit($id)
  {
    $todo = Todo::findOrFail($id);
    return view('todos.edit', compact('todo'));
  }
  
  public function update(Request $request, $id)
  {
    // Validate and update the data
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'status' => 'required',
    ]);

    // Update the todo
    $todo = Todo::findOrFail($id);
    $todo->title = $validatedData['title'];
    $todo->description = $validatedData['description'];
    $todo->status = $validatedData['status'];
    $todo->save();

    return redirect()->route('todos.index')->with('success', 'Todo updated successfully.');
  }
  
  public function destroy($id)
  {
    $todo = Todo::findOrFail($id);
    $todo->delete();

    return redirect()->route('todos.index')->with('success', 'Todo deleted successfully.');
  }
}
