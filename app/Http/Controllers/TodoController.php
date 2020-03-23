<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of all todos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Todo::orderBy('id', 'desc')->paginate(10);
        return view('todos.index', compact('datas'));
    }

    /**
     * Display a listing of done's todos
     */
    public function done()
    {
        $datas = Todo::where('done', 1)->paginate(10);
        return view('todos.index', compact('datas'));
    }

    /**
     * Display a listing of undone's todos
     */
    public function undone()
    {
        $datas = Todo::where('done', 0)->paginate(10);
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
