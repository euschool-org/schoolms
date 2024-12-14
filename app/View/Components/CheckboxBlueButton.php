<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckboxBlueButton extends Component
{
    public $item;
    public $label;
    /**
     * Create a new component instance.
     */
    public function __construct($item, $label)
    {
        $this->item = $item;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkbox-blue-button');
    }
}
