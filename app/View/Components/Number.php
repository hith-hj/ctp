<?php

namespace App\View\Components;

use Illuminate\View\View;

class Number extends BaseComponent
{
    /**
     * @var int
     */
    public $min;

    /**
     * @var int
     */
    public $max;

    /**
     * @var bool
     */
    public $decimal;

    /**
     * @var bool
     */
    public $percentage;

    /**
     * @var bool
     */
    public $readonly;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  bool  $required
     * @param  string  $locale
     * @param  null  $oldValue
     * @param  int  $min
     * @param  int  $max
     * @param  bool  $decimal
     * @param  bool  $percentage
     * @param  bool  $readonly
     */
    public function __construct($name = '', $required = false, $locale = '', $oldValue = null, $min = 0, $max = 999999, $decimal = false, $percentage = false, $readonly = false)
    {
        parent::__construct($name, $required, $locale, $oldValue);
        $this->min = $min;
        $this->max = $max;
        $this->decimal = $decimal;
        $this->readonly = $readonly;
        $this->percentage = $percentage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.number');
    }
}
