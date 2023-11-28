<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * The label , name , type and class for component.
     *
     * @var string
     */
    public string $label;
    public string $name;
    public string $type;
    public string $class;
    public string $attr;
    public string $value;
    public function __construct($label,$name,$type,$class='',$attr='',$value='')
    {
        $this->label=$label;
        $this->name=$name;
        $this->type=$type;
        $this->class=$class;
        $this->attr=$attr;
        $this->value=$value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
