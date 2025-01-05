<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todo = new Todo();
        $todos = $todo->all();

        return view('resources.todo.index', ['todos' => $todos]);
        // 修正
    }

    public function create()
    {
        TODO::all();
        return view('resources.todo.create'); // 追記
    }

    public function store(Request $request) // 追記
    {
        $content = $request->input('content'); // 追記

        // 1. todosテーブルの1レコードを表すTodoクラスをインスタンス化
        $todo = new Todo();
        // 2. Todoインスタンスのカラム名のプロパティに保存したい値を代入
        $todo->content = $content;
        // 3. Todoインスタンスの`->save()`を実行してオブジェクトの状態をDBに保存するINSERT文を実行
        $todo->save();

        return redirect()->route('todo.index'); // 追記
    
        // dd($content);
    }
    
}
