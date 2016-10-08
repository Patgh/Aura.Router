<?php
namespace Aura\Router\Helper;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\RouterContainer;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    protected $map;
    protected $generator;

    protected function setUp()
    {
        parent::setUp();
        $container = new RouterContainer();
        $this->map = $container->getMap();
        $this->generator = $container->getGenerator();
    }

    public function testInvokeReturnsGeneratedRoute()
    {
        $this->map->route('test', '/blog/{id}/edit')
                  ->tokens([
                      'id' => '([0-9]+)',
                  ]);

        $helper = new Url($this->generator);
        $this->assertEquals('/blog/4%202/edit', $helper('test', ['id' => '4 2', 'foo' => 'bar']));
    }

    public function testInvokeReturnsRaw()
    {
        $this->map->route('test', '/blog/{id}/edit')
                  ->tokens([
                      'id' => '([0-9]+)',
                  ]);

        $helper = new Url($this->generator);

        $this->setExpectedException(RouteNotFound::class);
        $this->assertEquals('/blog/4 2/edit', $helper('tester', ['id' => '4 2', 'foo' => 'bar']));
    }
}
