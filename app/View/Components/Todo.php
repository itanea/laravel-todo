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
        //echo 'in app/view/Components';
        //dd($data);
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
        //dd($this->data);
        return view('components.todo');
    }
}
