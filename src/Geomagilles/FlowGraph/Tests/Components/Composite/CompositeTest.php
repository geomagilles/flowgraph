<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Graph;

use Mockery;
use Geomagilles\FlowGraph\Tests\BaseTest;

/**
 * Test class for Point.
 */
class GraphTest extends BaseTest
{
    const TESTED_CLASS = 'Geomagilles\FlowGraph\Components\Graph\Graph';

    /**
     * The factory mock.
     * @var mixed
     */
    protected $factory;

    /**
     * The graph mock.
     * @var mixed
     */
    protected $graph;

    public function tearUp()
    {
        $this->factory = Mockery::mock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        return $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $this->factory));
    }

    public function testConstructor()
    {
        $graph = $this->tearUp();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Component', $graph);
        $this->assertEquals('', $graph->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $graph->getFactory());
    }

    public function testAddGraph()
    {
        $graph = $this->tearUp();
        $comp1     = Mockery::mock(self::TESTED_CLASS);
        $comp1->shouldReceive('getName')->andReturn('c1');

        $this->factory
            ->shouldReceive('createGraph')
            ->with('c1')
            ->ordered()
            ->andReturn($comp1);
    
        $graph->addGraph('c1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($comp1, $boxes[0]);
    }

    public function testAddTask()
    {
        $graph = $this->tearUp();
        $task1 = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Task\Task');
        $task1->shouldReceive('getName')->andReturn('t1');

        $this->factory
            ->shouldReceive('createTask')
            ->with('t1')
            ->ordered()
            ->andReturn($task1);

        $graph->addTask('t1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($task1, $boxes[0]);
    }

    public function testAddComplexTask()
    {
        $graph = $this->tearUp();
        $task1 = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Task\Task');
        $task1->shouldReceive('getName')->andReturn('t1');

        $this->factory
            ->shouldReceive('createDecision')
            ->with('t1')
            ->ordered()
            ->andReturn($task1);

        $graph->addComplexTask('t1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($task1, $boxes[0]);
    }

    public function testAddBegin()
    {
        $graph = $this->tearUp();
        $task1 = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Task\Task');
        $task1->shouldReceive('getName')->andReturn('t1');

        $this->factory
            ->shouldReceive('createBegin')
            ->with('t1')
            ->ordered()
            ->andReturn($task1);

        $graph->addBegin('t1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($task1, $boxes[0]);
    }

    public function testAddEnd()
    {
        $graph = $this->tearUp();
        $task1 = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Task\Task');
        $task1->shouldReceive('getName')->andReturn('t1');

        $this->factory
            ->shouldReceive('createEnd')
            ->with('t1')
            ->ordered()
            ->andReturn($task1);

        $graph->addEnd('t1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($task1, $boxes[0]);
    }

    public function testAddSynchronizer()
    {
        $graph = $this->tearUp();
        $synch1    = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Synchronizer\Synchronizer');
        $synch1->shouldReceive('getName')->andReturn('s1');

        $this->factory
            ->shouldReceive('createSynchronizer')
            ->with('s1')
            ->ordered()
            ->andReturn($synch1);
    
        $graph->addSynchronizer('s1');
        $boxes = $graph->getComponents();
        $this->assertCount(1, $boxes);
        $this->assertSame($synch1, $boxes[0]);
    }

    public function testAddBox()
    {
        $graph = $this->tearUp();
        $box       = $this->getMockForAbstractClass('Geomagilles\FlowGraph\Components\Component', array('b1', $this->factory));
        
        $this->assertCount(0, $graph->getComponents());
        $this->invokeMethod($graph, 'addComponent', array($box));
        $this->assertCount(1, $graph->getComponents());
        $this->assertSame($graph, $box->getGraph());
        $this->invokeMethod($graph, 'addComponent', array($box));
        $this->assertCount(1, $graph->getComponents());
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddBoxWithSameName()
    {
        $graph = $this->tearUp();
        $box1       = $this->getMockForAbstractClass('Geomagilles\FlowGraph\Components\Component', array('b1', $this->factory));
        $box2       = $this->getMockForAbstractClass('Geomagilles\FlowGraph\Components\Component', array('b1', $this->factory));
        
        $this->invokeMethod($graph, 'addComponent', array($box1));
        $this->invokeMethod($graph, 'addComponent', array($box2));
    }

    /**
     * @expectedException \LogicException
     */
    public function testRecursiveAddBox()
    {
        $graph = $this->tearUp();
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('b', $this->factory));
        
        $this->invokeMethod($graph, 'addComponent', array($box));
        $this->invokeMethod($box, 'addComponent', array($graph));
    }
    
    public function testAddArc()
    {
        $graph = $this->tearUp();
        $arc       = Mockery::mock('Geomagilles\FlowGraph\Arc\ArcInterface');
        $input     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $output    = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $begin     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $this->factory
            ->shouldReceive('createArc')
            ->once()
            ->with($output, $input)
            ->andReturn($arc);

        $begin
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $begin
            ->shouldReceive('getOutputPoint')
            ->andReturn($output);
        $end
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $end
            ->shouldReceive('getInputPoint')
            ->andReturn($input);

        $this->assertCount(0, $this->invokeMethod($graph, 'getArcs'));
        $arc = $graph->addArc($begin, $end);
        $arcs = $this->invokeMethod($graph, 'getArcs');
        $this->assertCount(1, $arcs);
        $this->assertSame($arc, $arcs[0]);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddArcWithUnknownBegin()
    {
        $graph = $this->tearUp();
        $begin     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
 
        $begin
            ->shouldReceive('getGraph')
            ->andReturn(new \stdClass);
        $end
            ->shouldReceive('getGraph')
            ->andReturn($graph);

        $graph->addArc($begin, $end);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddArcWithUnknownEnd()
    {
        $graph = $this->tearUp();
        $begin     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $begin
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $end
            ->shouldReceive('getGraph')
            ->andReturn(new \stdClass);
        
        $graph->addArc($begin, $end);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddArcWithoutOutputPoint()
    {
        $graph = $this->tearUp();
        $input     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $output    = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $begin     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $begin
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $begin
            ->shouldReceive('getOutputPoint')
            ->andReturn(null);
        $end
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $end
            ->shouldReceive('getInputPoint')
            ->andReturn($input);

        $this->assertCount(0, $this->invokeMethod($graph, 'getArcs'));
        $arc = $graph->addArc($begin, $end);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddArcWithoutInputPoint()
    {
        $graph = $this->tearUp();
        $input   = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $output  = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $begin   = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $begin
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $begin
            ->shouldReceive('getOutputPoint')
            ->andReturn($output);
        $end
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $end
            ->shouldReceive('getInputPoint')
            ->andReturn(null);

        $this->assertCount(0, $this->invokeMethod($graph, 'getArcs'));
        $arc = $graph->addArc($begin, $end);
    }

    public function testAddArcWithSynchronizer()
    {
        $graph = $this->tearUp();
        $arc       = Mockery::mock('Geomagilles\FlowGraph\Arc\ArcInterface');
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $output    = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $begin     = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $end       = Mockery::mock('Geomagilles\FlowGraph\Components\Units\Synchronizer\SynchronizerInterface');

        $this->factory
            ->shouldReceive('createArc')
            ->once()
            ->with($output, $point)
            ->andReturn($arc);
        $this->factory
            ->shouldReceive('createPoint')
            ->once()
            ->andReturn($point);
        $begin
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $begin
            ->shouldReceive('getOutputPoint')
            ->andReturn($output);
        $end
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        $end
            ->shouldReceive('addInputPoint')
            ->once()
            ->with($point);

        $this->assertCount(0, $this->invokeMethod($graph, 'getArcs'));
        $arc = $graph->addArc($begin, $end);
        $arcs = $this->invokeMethod($graph, 'getArcs');
        $this->assertCount(1, $arcs);
        $this->assertSame($arc, $arcs[0]);
    }

    public function testClonePoint()
    {
        $graph = $this->tearUp();
        $clone     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');

        $this->factory
            ->shouldReceive('createPoint')
            ->once()
            ->andReturn($clone);
        $clone
            ->shouldReceive('setSubjacentPoint')
            ->once()
            ->with($point);
        $point
            ->shouldReceive('getComponent')
            ->andReturn($box);
        $point
            ->shouldReceive('getName')
            ->once()
            ->andReturn('');
        $box
            ->shouldReceive('getGraph')
            ->andReturn($graph);
        
        $this->assertSame($clone, $this->invokeMethod($graph, 'clonePoint', array($point)));
    }

    /**
     * @expectedException \LogicException
     */
    public function testClonePointWithoutBox()
    {
        $graph = $this->tearUp();
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        
        $point
            ->shouldReceive('getComponent')
            ->andReturn(null);

        $this->invokeMethod($graph, 'clonePoint', array($point));
    }

    /**
     * @expectedException \LogicException
     */
    public function testClonePointWithoutGraph()
    {
        $graph = $this->tearUp();
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');
        
        $box
            ->shouldReceive('getGraph')
            ->andReturn(null);
        $point
            ->shouldReceive('getComponent')
            ->andReturn($box);
        
        $this->invokeMethod($graph, 'clonePoint', array($point));
    }

    public function testAddInputPoint()
    {
        $graph = $this->tearUp();
        $clone     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $clone->shouldReceive('getName');
        $point->shouldReceive('getName');
        $point
            ->shouldReceive('getComponent')
            ->atLeast()->once()
            ->andReturn($box);
        $box
            ->shouldReceive('getGraph')
            ->atLeast()->once()
            ->andReturn($graph);
        $this->factory
            ->shouldReceive('createPoint')
            ->once()
            ->andReturn($clone);
        $clone
            ->shouldReceive('setSubjacentPoint')
            ->once()
            ->with($point);
        $clone
            ->shouldReceive('setBox')
            ->once()
            ->with($graph);

        $graph->addInputPoint($point);
        $inputs = $graph->getInputPoints();
        $this->assertSame($clone, $inputs[0]);
    }

    public function testAddOutputPoint()
    {
        $graph = $this->tearUp();
        $clone     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $clone->shouldReceive('getName');
        $point->shouldReceive('getName');
        $point
            ->shouldReceive('getComponent')
            ->atLeast()->once()
            ->andReturn($box);
        $box
            ->shouldReceive('getGraph')
            ->atLeast()->once()
            ->andReturn($graph);
        $this->factory
            ->shouldReceive('createPoint')
            ->once()
            ->andReturn($clone);
        $clone
            ->shouldReceive('setSubjacentPoint')
            ->once()
            ->with($point);
        $clone
            ->shouldReceive('setBox')
            ->once()
            ->with($graph);

        $graph->addOutputPoint($point);
        $outputs = $graph->getOutputPoints();
        $this->assertSame($clone, $outputs[0]);
    }

    public function testGetPetriBuilder()
    {
        $graph = $this->tearUp();

        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $graph->getPetriBuilder());
    }

    //public function testGetTransitionFromInputPoint()
    //{
    //    $graph = $this->tearUp();
    //    $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
    //    $subBox    = Mockery::mock('Geomagilles\FlowGraph\Components\Component[getTransitionFromInputPoint]');
    //    $subPoint  = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
    //
    //    $point
    //        ->shouldReceive('getSubjacentPoint')
    //        ->once()
    //        ->andReturn($subPoint);
    //    $subPoint
    //        ->shouldReceive('getComponent')
    //        ->once()
    //        ->andReturn($subBox);
    //    $subBox
    //        ->shouldReceive('getTransitionFromInputPoint')
    //        ->once()
    //        ->with($subPoint)
    //        ->andReturn('newTransition');
    //
    //    $transition = $this->invokeMethod($graph, 'getTransitionFromInputPoint', array($point));
    //    $this->assertSame('newTransition', $transition);
    //}

    //public function testGetTransitionFromOutputPoint()
    //{
    //    $graph = $this->tearUp();
    //    $point     = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
    //    $subBox    = Mockery::mock('Geomagilles\FlowGraph\Components\Component[getTransitionFromOutputPoint]');
    //    $subPoint  = Mockery::mock('Geomagilles\FlowGraph\Point\PointInterface');
    //
    //    $point
    //        ->shouldReceive('getSubjacentPoint')
    //        ->once()
    //        ->andReturn($subPoint);
    //    $subPoint
    //        ->shouldReceive('getComponent')
    //        ->once()
    //        ->andReturn($subBox);
    //    $subBox
    //        ->shouldReceive('getTransitionFromOutputPoint')
    //        ->once()
    //        ->with($subPoint)
    //        ->andReturn('newTransition');
    //
    //    $transition = $this->invokeMethod($graph, 'getTransitionFromOutputPoint', array($point));
    //    $this->assertSame('newTransition', $transition);
    //}

    public function testIsGraph()
    {
        $graph = $this->tearUp();

        $this->assertTrue($this->invokeMethod($graph, 'isGraph'));
    }
}
