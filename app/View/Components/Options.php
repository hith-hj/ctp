<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Options extends Component
{
    /**
     * The Attr colors.
     */
    public $colors;

    /**
     * The Attr options.
     */
    public $options;

    /**
     * The Attr sizes.
     */
    public $sizes;

    /**
     * The Attr productId.
     */
    public $productId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($colors = [], $options = null, $sizes = [], $productId = null)
    {
        $this->colors = $colors;
        $this->options = $options;
        $this->sizes = $sizes;
        $this->productId = $productId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('admin.components.options');
    }
}
