<?php

namespace App\View\Components;

use Illuminate\View\View;

class Color extends BaseComponent
{
    /**
     * @var bool
     */
    public $readonly;

    public function __construct($name = '', $required = false, $locale = 'en', $oldValue = '', $readonly = false)
    {
        parent::__construct($name, $required, $locale, $oldValue);
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.color');
    }
}
