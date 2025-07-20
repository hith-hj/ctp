<?php

namespace App\View\Components;

use Illuminate\View\View;

class File extends BaseComponent
{
    /**
     * @var bool
     */
    public $multiple;

    public function __construct($name = '', $required = false, $locale = 'en', $oldValue = '', $multiple = false)
    {
        parent::__construct($name, $required, $locale, $oldValue);
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.file');
    }
}
