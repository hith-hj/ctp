<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Checkbox extends Component
{
    /**
     * The Attr name.
     *
     * @var string
     */
    public $name;

    /**
     * The Choices.
     *
     * @var array
     */
    public $choices;

    /**
     * The Required.
     *
     * @var bool
     */
    public $required;

    /**
     * The Attr oldValue.
     */
    public $oldValue;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  array  $choices
     * @param  bool  $required
     * @param  object  $oldValue
     */
    public function __construct($name = '', $choices = [], $required = false, $oldValue = null)
    {
        $this->name = $name;
        $this->choices = $choices;
        $this->required = $required;
        $this->oldValue = $oldValue;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.checkbox');
    }
}
