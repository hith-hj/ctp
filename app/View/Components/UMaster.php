<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UMaster extends Component
{
    /**
     * @var string
     */
    public $title;

    public function __construct($title = '')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('user.components.u-master');
    }
}
