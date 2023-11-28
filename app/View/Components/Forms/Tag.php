<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Tag extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public string $value;

    public function __construct($value='')
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.tag');
    }
}
