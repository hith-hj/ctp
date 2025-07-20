<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectAjaxData extends BaseComponent
{
    /**
     * @var bool
     */
    public $multiple;

    /**
     * @var bool
     */
    public $label;

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
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  string  $displayName
     * @param  bool  $required
     * @param  string  $locale
     * @param  null  $oldValue
     * @param  array  $oldValues
     * @param  bool  $multiple
     * @param  bool  $all
     * @param  string  $url
     * @param  bool  $label
     */
    public function __construct($name = '', $displayName = 'title', $required = false, $locale = 'en', $oldValue = null, $multiple = false, $all = false, $oldValues = [], $url = '', $label = true)
    {
        parent::__construct($name, $required, $locale, $oldValue);
        $this->multiple = $multiple;
        $this->locale = $locale;
        $this->all = $all;
        $this->oldValues = $oldValues;
        $this->displayName = $displayName;
        $this->url = $url;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.select-ajax-data');
    }
}
