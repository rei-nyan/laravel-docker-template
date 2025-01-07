<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest; // 追加
use App\Todo;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function index()
    {
        $todos = $this->todo->all();

        return view('resources.todo.index', ['todos' => $todos]);
        // 修正
    }

    public function create()
    {
        TODO::all();
        return view('resources.todo.create'); // 追記
    }

    public function store(TodoRequest $request) // 追記
    {
        $inputs = $request->all();

        $this->todo->fill($inputs); // 変更
        $this->todo->save(); // 変更

        return redirect()->route('todo.index'); // 追記
    
        // dd($content);
    }

    public function show($id)
    {
        $todo = $this->todo->find($id);

        return view('resources.todo.show', ['todo' => $todo]);
    }

    // TODO: ルートパラメータを引数に受け取る
    public function edit($id)
    {
    // TODO: 編集対象のレコードの情報を持つTodoモデルのインスタンスを取得
        $todo = $this->todo->find($id);

        return view('resources.todo.edit',['todo'=> $todo]);
    }

    public function update(TodoRequest $request, $id) // 第1引数: リクエスト情報の取得　第2引数: ルートパラメータの取得
    {
        // TODO: リクエストされた値を取得
        $inputs =$request->all();
        // TODO: 更新対象のデータを取得
        $todo =$this->todo->find($id);
        // TODO: 更新したい値の代入とUPDATE文の実行
        $todo->fill($inputs);
        $todo->save(); //dbに保存

        return redirect()->route('todo.show', $todo->id);

    }

    public function delete($id)
    {
        $todo=$this->todo->find($id);
        $todo->delete();

        return redirect()->route('todo.index', $todo->id);
    }
    
}

