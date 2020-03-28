<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Todo extends Component
{

    public $datas;
    public $users;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($datas, $users)
    {
        $this->datas = $datas;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.todo');
    }
}
