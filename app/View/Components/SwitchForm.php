<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SwitchForm extends Component
{
    /**
     * The Attr name.
     *
     * @var string
     */
    public $name;

    /**
     * The Attr locale.
     *
     * @var string
     */
    public $locale;

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
     * @param  bool  $required
     * @param  string  $oldValue
     * @param  string  $locale
     */
    public function __construct($name = '', $required = false, $locale = 'en', $oldValue = false)
    {
        $this->name = $name;
        $this->required = $required;
        $this->oldValue = $oldValue;
        $this->locale = $locale;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.switch-form');
    }
}
