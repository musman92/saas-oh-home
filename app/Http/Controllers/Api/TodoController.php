<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;

class TodoController extends Controller
{
  public function index(Request $request)
  {
    $data = Todo::select('todos.id', 'todos.title', 'todos.description', 'todos.status', 'todos.created_at')
      ->where('todos.user_id', $request->user()->id)
      ->get();

    return response()->json(['data' => $data], 200);
  }
  // create store pi
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'description' => 'required',
    ]);

    $todo = new Todo();
    $todo->title = $request->title;
    $todo->description = $request->description;
    $todo->user_id = $request->user()->id;
    $todo->save();

    return response()->json(['message' => 'Todo created successfully'], 201);
  }
  // create get api
  public function get($id)
  {
    $todo = Todo::find($id);
    return response()->json(['data' => $todo], 200);
  }
  // create update pi
  public function update(Request $request, $id)
  {
    $request->validate([
      'title' => 'required',
      'description' => 'required',
      'status' => 'nullable|in:pending,completed',
    ]);

    $todo = Todo::find($id);
    $todo->title = $request->title;
    $todo->description = $request->description;
    if ($request->status) {
      $todo->status = $request->status;
    }
    $todo->save();

    return response()->json(['message' => 'Todo updated successfully'], 200);
  }
  // create delete pi
  public function destroy(Request $request, $id)
  {
    $todo = Todo::find($id);
    $todo->delete();

    return response()->json(['message' => 'Todo deleted successfully'], 200);
  }
}
