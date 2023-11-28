<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Button extends Component
{

    public string $class;
    public string $text;

    public function __construct($class,$text)
    {
        $this->class=$class;
        $this->text=$text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.button');
    }
}
