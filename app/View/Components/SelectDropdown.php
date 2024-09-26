<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectDropdown extends Component
{
    public $options;
    public $label;
    public $name;

    public function __construct($options = [], $name = '', $label = 'Select')
    {
        $this->options = $options;
        $this->label = $label;
        $this->name = $name;
    }

    public function render()
    {
        return view('components.select-dropdown');
    }
}
