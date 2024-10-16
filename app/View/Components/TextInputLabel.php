<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextInputLabel extends Component
{

    public $name;

    public $label;

    public $value;

    public $type;

    public function __construct($name, $label, $value = null, $type = 'text')
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-input-label');
    }
}
