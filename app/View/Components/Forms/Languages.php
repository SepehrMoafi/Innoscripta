<?php

namespace App\View\Components\Forms;

use Features\Languages\Language;
use Illuminate\View\Component;

class Languages extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $languages=Language::all();
        return view('components.forms.languages',compact('languages'));
    }
}
