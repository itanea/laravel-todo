<?php

namespace App\Http\Controllers;

use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{


    public $users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->users = User::getAllUsers();
    }

    /**
     * Assign a todo to an user
     *
     * @param  App\Todo  $todo
     * @param  App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function affectedto(Todo $todo, User $user)
    {

        $todo->affectedTo_id = $user->id == Auth::user()->id ? 0 : $user->id;
        $todo->affectedBy_id = Auth::user()->id;
        $todo->update();

        $message = $user->id == Auth::user()->id ?
            "La todo <span class='badge badge-dark'>#$todo->id</span> m'a bien été ré-affectée." :
            "La todo <span class='badge badge-dark'>#$todo->id</span> a bien été affectée à $user->name.";
        toastr()->success($message);
        return back();
    }

    /**
     * Display a listing of all todos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$datas = Todo::where('creator_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        $datas = Auth::user()->todos()->orderBy('id', 'desc')->paginate(10);
        $users = $this->users;

        // $affectedto = Todo::where('affectedTo_id', Auth::user()->id)->paginate(10);
        //$datas = Todo::orderBy('id', 'desc')->paginate(10);
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Display a listing of done's todos
     */
    public function done()
    {
        $datas = Auth::user()->todos()->where('done', 1)->paginate(10);
        return view('todos.index', compact('datas'));
    }

    /**
     * Display a listing of undone's todos
     */
    public function undone()
    {
        $datas = Auth::user()->todos()->where('done', 0)->paginate(10);
        return view('todos.index', compact('datas'));
    }


    /**
     * Action to change todo's status to done
     */
    public function makedone(Todo $todo)
    {
        $todo->done = 1;
        $todo->update();
        toastr()->success("La todo <span class='badge badge-dark'>#$todo->id</span> a bien été terminée.");
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->creator_id = Auth::user()->id;
        $todo->affectedTo_id = Auth::user()->id;
        $todo->name = $request->name;
        $todo->description = $request->description;
        if(isset($request->done))
        {
            $todo->done = $request->done;
        }
        $todo->save();

        toastr()->success("La todo <span class'badge badge-dark'>#$todo->id</span> vient d'être créée.");
        return redirect()->route('todos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if (!isset ($request->done)) {
            $request['done'] = 0;
        }

        $todo->update($request->all());

        toastr()->success("La todo <span class'badge badge-dark'>#$todo->id</span> a bien été mise à jour.");
        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        toastr()->error("La todo <span class='badge badge-dark'>#$todo->id</span> a bien été supprimée.");

        return back();
    }
}
