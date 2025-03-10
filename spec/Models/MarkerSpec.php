<?php

namespace spec\FifyIO\Googlmapper\Models;

use FifyIO\Googlmapper\Models\Marker;
use Illuminate\View\Factory as View;
use Mockery;
use PhpSpec\ObjectBehavior;

class MarkerSpec extends ObjectBehavior
{
    private const STRING = 'test';
    private const INTEGER = 10;

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Marker::class);
    }

    public function it_can_render_a_maker()
    {
        $view = Mockery::mock(View::class);
        $view->shouldReceive('make')->andReturn($view);
        $view->shouldReceive('withOptions')->andReturn($view);
        $view->shouldReceive('withId')->andReturn($view);
        $view->shouldReceive('withView')->andReturn($view);
        $view->shouldReceive('render')->andReturn(self::STRING);
        $this->render(self::INTEGER, $view)->shouldReturn(self::STRING);
    }
}
