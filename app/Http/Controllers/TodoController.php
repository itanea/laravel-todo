<?php

namespace App\Http\Controllers;

use App\Notifications\TodoAffected;
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
       // $this->authorizeResource(Todo::class, 'todos');
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

        $user->notify(new TodoAffected($todo));

        $message = $user->id == Auth::user()->id ?
            "La todo <span class='badge badge-dark'>#$todo->id</span> m'a bien été ré-affectée." :
            "La todo <span class='badge badge-dark'>#$todo->id</span> a bien été affectée à $user->name.";
        toastr()->success($message);
        return back();
    }

    /**
     * Display a listing of all todos (created by connected user or affected to connected user)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $datas = Todo::where(['creator_id' => $userId])->orWhere(['affectedTo_id' => $userId])->orderBy('id', 'desc')->paginate(10);

        //$datas = Auth::user()->todos()->orderBy('id', 'desc')->paginate(10);
        $users = $this->users;

        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Display a listing of done's todos
     */
    public function done()
    {
        $datas = Auth::user()->todos()->where('done', 1)->paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Display a listing of undone's todos
     */
    public function undone()
    {
        // $datas = Auth::user()->todos()->where('done', 0)->paginate(10);
        $datas = Todo::where(['done' => 0])->paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    public function createdByMe()
    {
        $datas = Todo::where('creator_id', Auth::user()->id)->paginate(10);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }


    /**
     * Action to change todo's status to done
     */
    public function makedone(Todo $todo)
    {
        $todo->done = 1;
        $todo->update();
        notify()->success("La todo <span class='badge badge-dark'>#$todo->id</span> a bien été terminée.");
        return back();
    }

    /**
     * Action to change todo's status to undone
     */
    public function makeundone(Todo $todo)
    {
        $todo->done = 0;
        $todo->update();
        toastr()->success("La todo <span class='badge badge-dark'>#$todo->id</span> est à nouveau ouverte.");
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

        toastr()->success("La todo <span class='badge badge-dark'>#$todo->id</span> vient d'être créée.");
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
        $this->authorize('edit', $todo);
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
        $this->authorize('delete', $todo);
        $todo->delete();
        toastr()->error("La todo <span class='badge badge-dark'>#$todo->id</span> a bien été supprimée.");

        return back();
    }

    public function filterCollectionVersion()
    {
        $v50 = explode(" ", "");
        $v51 = explode(" ", "all average avg chunk collapse contains count diff each every except filter first flatMap flatten flip forget forPage get groupBy has implode intersect isEmpty keyBy keys last map max merge min only pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc splice sum take toArray toJson transform unique values where whereLoose zip");
        $v52 = explode(" ", "all average avg chunk collapse combine contains count diff diffKeys each every except filter first flatMap flatten flip forget forPage get groupBy has implode intersect isEmpty keyBy keys last map max median merge min mode only pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc splice sum take toArray toJson transform union unique values where whereLoose whereIn whereInLoose zip");
        $v53 = explode(" ", "all average avg chunk collapse combine contains containsStrict count diff diffKeys each every except filter first flatMap flatten flip forget forPage get groupBy has implode intersect isEmpty isNotEmpty keyBy keys last map mapWithKeys max median merge min mode only partition pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc splice split sum take toArray toJson transform union unique uniqueStrict values where whereStrict whereIn whereInStrict zip");
        $v54 = explode(" ", "all average avg chunk collapse combine concat contains containsStrict count diff diffAssoc diffKeys each every except filter first flatMap flatten flip forget forPage get groupBy has implode intersect intersectKey isEmpty isNotEmpty keyBy keys last map mapWithKeys max median merge min mode nth only partition pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict values when where whereStrict whereIn whereInStrict whereNotIn whereNotInStrict zip");
        $v55 = explode(" ", "all average avg chunk collapse combine concat contains containsStrict count crossJoin dd diff diffAssoc diffKeys dump each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unwrap values when where whereStrict whereIn whereInStrict whereNotIn whereNotInStrict wrap zip");
        $v56 = explode(" ", "all average avg chunk collapse combine concat contains containsStrict count crossJoin dd diff diffAssoc diffKeys dump each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice sort sortBy sortByDesc sortKeys sortKeysDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unwrap values when where whereStrict whereIn whereInStrict whereInstanceOf whereNotIn whereNotInStrict wrap zip");
        $v57 = explode(" ", "all average avg chunk collapse combine concat contains containsStrict count crossJoin dd diff diffAssoc diffKeys dump each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject reverse search shift shuffle slice some sort sortBy sortByDesc sortKeys sortKeysDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unlessEmpty unlessNotEmpty unwrap values when whenEmpty whenNotEmpty where whereStrict whereBetween whereIn whereInStrict whereInstanceOf whereNotBetween whereNotIn whereNotInStrict wrap zip");
        $v58 = explode(" ", "all average avg chunk collapse combine concat contains containsStrict count countBy crossJoin dd diff diffAssoc diffKeys dump duplicates duplicatesStrict each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty join keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge mergeRecursive min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject replace replaceRecursive reverse search shift shuffle slice some sort sortBy sortByDesc sortKeys sortKeysDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unlessEmpty unlessNotEmpty unwrap values when whenEmpty whenNotEmpty where whereStrict whereBetween whereIn whereInStrict whereInstanceOf whereNotBetween whereNotIn whereNotInStrict wrap zip");
        $v6x = explode(" ", "all average avg chunk collapse collect combine concat contains containsStrict count countBy crossJoin dd diff diffAssoc diffKeys dump duplicates duplicatesStrict each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty join keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge mergeRecursive min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject replace replaceRecursive reverse search shift shuffle skip slice some sort sortBy sortByDesc sortKeys sortKeysDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unlessEmpty unlessNotEmpty unwrap values when whenEmpty whenNotEmpty where whereStrict whereBetween whereIn whereInStrict whereInstanceOf whereNotBetween whereNotIn whereNotInStrict whereNotNull whereNull wrap zip");
        $v7x = explode(" ", "all average avg chunk collapse collect combine concat contains containsStrict count countBy crossJoin dd diff diffAssoc diffKeys dump duplicates duplicatesStrict each eachSpread every except filter first firstWhere flatMap flatten flip forget forPage get groupBy has implode intersect intersectByKeys isEmpty isNotEmpty join keyBy keys last macro make map mapInto mapSpread mapToGroups mapWithKeys max median merge mergeRecursive min mode nth only pad partition pipe pluck pop prepend pull push put random reduce reject replace replaceRecursive reverse search shift shuffle skip slice some sort sortBy sortByDesc sortDesc sortKeys sortKeysDesc splice split sum take tap times toArray toJson transform union unique uniqueStrict unless unlessEmpty unlessNotEmpty unwrap values when whenEmpty whenNotEmpty where whereStrict whereBetween whereIn whereInStrict whereInstanceOf whereNotBetween whereNotIn whereNotInStrict whereNotNull whereNull wrap zip");

        echo '<h2>diff entre 5.0 et 5.1</h2>';
        dump(array_diff($v51, $v50));
        echo '<p>' . count($v51) . ' méthodes dans la version 5.1</p>';

        echo '<h2>diff entre 5.1 et 5.2</h2>';
        dump(array_diff($v52, $v51));
        echo '<p>' . count($v52) . ' méthodes dans la version 5.2</p>';

        echo '<h2>diff entre 5.2 et 5.3</h2>';
        dump(array_diff($v53, $v52));
        echo '<p>' . count($v53) . ' méthodes dans la version 5.3</p>';

        echo '<h2>diff entre 5.3 et 5.4</h2>';
        dump(array_diff($v54, $v53));
        echo '<p>' . count($v54) . ' méthodes dans la version 5.4</p>';

        echo '<h2>diff entre 5.5 et 5.4</h2>';
        dump(array_diff($v55, $v54));
        echo '<p>' . count($v55) . ' méthodes dans la version 5.5</p>';

        echo '<h2>diff entre 5.5 et 5.6</h2>';
        dump(array_diff($v56, $v55));
        echo '<p>' . count($v56) . ' méthodes dans la version 5.6</p>';

        echo '<h2>diff entre 5.6 et 5.7</h2>';
        dump(array_diff($v57, $v56));
        echo '<p>' . count($v57) . ' méthodes dans la version 5.7</p>';

        echo '<h2>diff entre 5.7 et 5.8</h2>';
        dump(array_diff($v58, $v57));
        echo '<p>' . count($v58) . ' méthodes dans la version 5.8</p>';

        echo '<h2>diff entre 6.x et 5.8</h2>';
        dump(array_diff($v6x, $v58));
        echo '<p>' . count($v6x) . ' méthodes dans la version 6.x</p>';

        echo '<h2>diff entre 7.x et 6.x</h2>';
        dump(array_diff($v7x, $v6x));
        echo '<p>' . count($v7x) . ' méthodes dans la version 7.x</p>';




        // Search diff between two strings
        $nested = collect([
            ["name" => "Spaghetti à la carbonara", "level" => "Moyen", "price" => "Economique", "type" => "Pâtes"],
            ["name" => "Loup entier grillé", "level" => "Chef", "price" => "Cher", "type" => "Poisson"],
            ["name" => "Gnocchi au pesto", "level" => "Facile", "price" => "Economique", "type" => "Pâtes"],
            ["name" => "Daurade vapeur et ses pommes de terre", "level" => "Moyen", "price" => "Moyen", "type" => "Poisson"],
            ["name" => "Dame blanche", "level" => "Moyen", "price" => "Moyen", "type" => "Dessert"],
            ["name" => "Banana Split", "level" => "Chef", "price" => "Cher", "type" => "Dessert"],
            ["name" => "Coupe Colonel", "level" => "Facile", "price" => "Economique", "type" => "Dessert"],
        ]);

        $filtered = $nested->each(function ($item, $key)
        {
            dd($item);
            $item->only(['name', 'price']);
        });
        //only(['name', 'price']);
        print_r($filtered->all());

        $collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);

        $filtered = $collection->only(['product_id', 'name']);

        $filtered->all();

        print_r($filtered);

    }
}
