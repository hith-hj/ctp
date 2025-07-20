<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProjectForm extends Component
{
    /**
     * The Attr action.
     *
     * @var string
     */
    public $action;

    /**
     * The Attr method.
     *
     * @var string
     */
    public $method;

    /**
     * The Attr submit.
     *
     * @var string
     */
    public $submit;

    /**
     * The Attr onelanguage.
     *
     * @var bool
     */
    public $onelanguage;

    /**
     * The Attr entity.
     */
    public $entity;

    /**
     * Create a new component instance.
     *
     * @param  string  $action
     * @param  string  $method
     * @param  string  $submit
     * @param  bool  $onelanguage
     * @param  null  $entity
     */
    public function __construct($action = '', $method = 'POST', $submit = 'POST', $onelanguage = false, $entity = null)
    {
        $this->action = $action;
        $this->method = $method;
        $this->submit = $submit;
        $this->onelanguage = $onelanguage;
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('user.project.project-form');
    }
}
