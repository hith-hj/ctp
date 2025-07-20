<?php

namespace App\View\Components;

use Illuminate\View\View;

class UText extends BaseComponent
{
    /**
     * @var bool
     */
    public $readonly;

    /**
     * @var mixed|string
     */
    public $relation;

    public function __construct($name = '', $relation = '', $required = false, $locale = 'en', $oldValue = '', $readonly = false, $valueName = '')
    {
        parent::__construct($name, $required, $locale, $oldValue, $valueName);
        $this->readonly = $readonly;
        $this->relation = $relation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('user.components.u-text');
    }
}
