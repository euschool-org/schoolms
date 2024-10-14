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
    public $value;

    public function __construct($options = [], $name = '', $label = 'Select', $value = false)
    {
        $this->options = $options;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        if ($this->value !== false) {
            return view('components.single-select');
        }
        return view('components.select-dropdown');
    }
}
