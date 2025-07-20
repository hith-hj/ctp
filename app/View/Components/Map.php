<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Map extends Component
{
    /**
     * The Attr latitude.
     *
     * @var float
     */
    public $latitude;

    /**
     * The Attr longitude.
     *
     * @var float
     */
    public $longitude;

    /**
     * Create a new component instance.
     *
     * @param  null  $latitude
     * @param  null  $longitude
     */
    public function __construct($latitude = null, $longitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.map');
    }
}
