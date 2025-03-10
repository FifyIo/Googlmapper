<?php

namespace FifyIO\Googlmapper\Models;

use FifyIO\Googlmapper\Contracts\ModelingInterface;
use Illuminate\View\Factory as View;

class Map implements ModelingInterface
{
    public const SHAPE_POLYLINE = 'polyline';
    public const SHAPE_POLYGON = 'polygon';
    public const SHAPE_RECTANGLE = 'rectangle';
    public const SHAPE_CIRCLE = 'circle';

    /**
     * Options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Markers.
     *
     * @var array
     */
    protected $markers = [];

    /**
     * Shapes.
     *
     * @var array
     */
    protected $shapes = [];

    /**
     * Public constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->options = $parameters;

        if (isset($this->options['marker']) && $this->options['marker']) {
            $this->marker($this->options['latitude'], $this->options['longitude'], $this->options);
        }
    }

    /**
     * Add a map marker to the markers bag.
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $options
     *
     * @return void
     */
    public function marker($latitude, $longitude, array $options = [])
    {
        $parameters = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        $parameters = array_replace_recursive(
            $this->options,
            $parameters,
            $options
        );

        $this->markers[] = new Marker($parameters);
    }

    /**
     * Add a map shape to the shapes bag.
     *
     * @param string $type
     * @param array  $coordinates
     * @param array  $options
     *
     * @return void
     */
    public function shape($type, $coordinates, array $options = [])
    {
        $parameters = [
            'coordinates' => $coordinates
        ];

        $parameters = array_replace_recursive(
            $this->options,
            $parameters,
            $options
        );

        switch ($type) {
            case self::SHAPE_POLYLINE:
                $this->shapes[] = new Polyline($parameters);
                break;
            case self::SHAPE_POLYGON:
                $this->shapes[] = new Polygon($parameters);
                break;
            case self::SHAPE_RECTANGLE:
                $this->shapes[] = new Rectangle($parameters);
                break;
            case self::SHAPE_CIRCLE:
                $this->shapes[] = new Circle($parameters);
                break;
        }
    }

    /**
     * Render the model item.
     *
     * @param int  $identifier
     * @param View $view
     *
     * @return string
     */
    public function render($identifier, View $view)
    {
        $options = $this->options;
        $options['markers'] = $this->getMarkers();
        $options['shapes'] = $this->getShapes();

        return $view->make('googlmapper::map')
            ->withOptions($options)
            ->withId($identifier)
            ->withView($view)
            ->render();
    }

    /**
     * Return marker items.
     *
     * @return array
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Return shape items.
     *
     * @return array
     */
    public function getShapes()
    {
        return $this->shapes;
    }

    /**
     * Get the model options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
