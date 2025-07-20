<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends BaseComponent
{
    /**
     * @var array
     */
    public $options;

    /**
     * @var bool
     */
    public $multiple;

    /**
     * @var bool
     */
    public $nullable;

    /**
     * @var bool
     */
    public $all;

    /**
     * @var array
     */
    public $oldValues;

    /**
     * @var string
     */
    public $displayName;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  string  $displayName
     * @param  bool  $required
     * @param  string  $locale
     * @param  null  $oldValue
     * @param  array  $options
     * @param  array  $oldValues
     * @param  bool  $multiple
     * @param  bool  $all
     */
    public function __construct($name = '', $displayName = 'title', $required = false, $locale = 'en', $oldValue = null, $options = [], $multiple = false, $all = false, $oldValues = [], $nullable = false)
    {
        parent::__construct($name, $required, $locale, $oldValue);
        $this->options = $options;
        $this->multiple = $multiple;
        $this->locale = $locale;
        $this->all = $all;
        $this->oldValues = $oldValues;
        $this->displayName = $displayName;
        $this->nullable = $nullable;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.select');
    }
}
