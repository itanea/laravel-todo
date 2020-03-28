<?php

namespace App\View\Components\todos;

use Illuminate\View\Component;

class todoInfo extends Component
{

    public $info;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($info)
    {

        //dd($data);
        $this->info = $info;
        //dd($this->data);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.todos.todo-info');
    }
}
