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
        // SELECT文
        $todos = $this->todo->all();
        // dd($todos);
        // object型の配列
        // Collection オブジェクト、Todo モデルのTodoインスタンスが1つずつ含まれている


        return view('resources.todo.index', ['todos' => $todos]);
        // 修正
        // view関数の第一引数
        // ディレクトリ構成index.blade.phpのHTML
        // ['todos' => $todos]
        // [blade内での変数=>代入したい値]連想配列の形で記述　$todos をビューに渡す
        //blade内で定義していないけど使える
    }

    public function create()
    {
        return view('resources.todo.create'); // 追記
    }

    public function store(TodoRequest $request) // 追記
    {
        $inputs = $request->all();
        // dd($request);
        // TodoRequest オブジェクトの内容
        // HTTPリクエストに関する情報(主にリクエストのパス、メソッド、送信されたデータ、サーバー情報、バリデーション情報)
        // dd($inputs);
        // array型
        // token,content(入力欄の内容)
        $this->todo->fill($inputs); // 変更
        // INSERT文
        $this->todo->save(); // 変更
        return redirect()->route('todo.index'); // 追記
    
    }

    public function show($id)
    {
        // SELECT文
        $todo = $this->todo->find($id);
        // dd($todo);
        // object型
        // todoクラスのインスタンス 関連するデータベース設定、属性、タイムスタンプの状態など、さまざまなプロパティに関する詳細
        // $todo は、find($id) メソッドによって、todos テーブルの1行分のデータ（IDが $id に一致するレコード）を取得してきた
        return view('resources.todo.show', ['todo' => $todo]);

    }

    // TODO: ルートパラメータを引数に受け取る
    public function edit($id)
    {
    // TODO: 編集対象のレコードの情報を持つTodoモデルのインスタンスを取得
        // INSERT文
        $todo = $this->todo->find($id);
        // object型
        //Todoクラスのインスタンス 関連するデータベース設定、属性、タイムスタンプの状態など、さまざまなプロパティに関する詳細
        // $todo は、find($id) メソッドによって、todos テーブルの1行分のデータ（IDが $id に一致するレコード）を取得してきた

        return view('resources.todo.edit',['todo'=> $todo]);
    }

    public function update(TodoRequest $request, $id) //requestクラスはなにか
    // 第1引数: リクエスト情報の取得　第2引数: ルートパラメータの取得
    {
        // TODO: リクエストされた値を取得
        $inputs = $request->all();
        // dd($inputs);
        // array型
        // token,method(PUT),content(入力欄の内容)

        // TODO: 更新対象のデータを取得
        $todo = $this->todo->find($id);
        // dd($todo);
        //object型
        //Todoクラスのインスタンス 関連するデータベース設定、属性、タイムスタンプの状態など、さまざまなプロパティに関する詳細

        // TODO: 更新したい値の代入
        // UPDATE文
        $todo->fill($inputs);
        //fill メソッド: 渡された配列のキーと値を、モデルの属性に一括で設定します。
        // dd($inputs);
        //array型 token,method,content
        // 編集した入力内容が入っている
        $todo->save(); //dbに保存

        return redirect()->route('todo.show', $todo->id);
    }

    public function delete($id)
    {
        $todo = $this->todo->find($id);
        // dd($todo);
        // object型
        //Todoクラスのインスタンス 関連するデータベース設定、属性、タイムスタンプの状態など、さまざまなプロパティに関する詳細
        // DELETE文
        $todo->delete();

        return redirect()->route('todo.index', $todo->id);
    }
    
}

// requestクラスは何か
// バリデーションを行うクラスの基本となるクラス
// フォームから入力したデータを受け取る
// HTTPリクエストの検証や認可を管理するための便利な方法を提供するクラス
// コントローラーでリクエストクラスを使用することで、リクエストデータのバリデーションが自動的に行われる
