<?php

namespace App\View\Components;

use Illuminate\View\View;

class Date extends BaseComponent
{
    public function __construct($name = '', $required = false, $locale = 'ar', $oldValue = '')
    {
        parent::__construct($name, $required, $locale, $oldValue);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.date');
    }
}
