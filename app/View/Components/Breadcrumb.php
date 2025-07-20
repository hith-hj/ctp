<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * @var string
     */
    public $item;

    /**
     * Create a new component instance.
     *
     * @param  string  $item
     */
    public function __construct($item = '')
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.breadcrumb');
    }
}
