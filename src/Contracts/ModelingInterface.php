<?php

namespace FifyIO\Googlmapper\Contracts;

use Illuminate\View\Factory as View;

interface ModelingInterface
{
    /**
     * Public constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = []);

    /**
     * Render the model item.
     *
     * @param int  $identifier
     * @param View $view
     *
     * @return string
     */
    public function render($identifier, View $view);

    /**
     * Get the model options.
     *
     * @return array
     */
    public function getOptions();
}
