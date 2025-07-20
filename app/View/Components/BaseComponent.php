<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BaseComponent extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $required;

    /**
     * The Attr locale.
     *
     * @var string
     */
    public $locale;

    /**
     * The Attr oldValue.
     */
    public $oldValue;

    /**
     * @var string
     */
    public $valueName;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  bool  $required
     * @param  string  $locale
     * @param  null  $oldValue
     * @param  string  $valueName
     */
    public function __construct($name = '', $required = false, $locale = 'en', $oldValue = null, $valueName = '')
    {
        $this->name = $name;
        $this->required = $required;
        $this->locale = $locale;
        $this->oldValue = $oldValue;
        if ($valueName == '') {
            $this->valueName = $this->name;
        } else {
            $this->valueName = $valueName;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        //        return view('Components.text-area');
    }
}
