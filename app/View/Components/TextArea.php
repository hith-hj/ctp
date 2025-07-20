<?php

namespace App\View\Components;

use Illuminate\View\View;

class TextArea extends BaseComponent
{
    public function __construct($name = '', $required = false, $locale = 'en', $oldValue = '', $valueName = '')
    {
        parent::__construct($name, $required, $locale, $oldValue, $valueName);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.text-area');
    }
}
