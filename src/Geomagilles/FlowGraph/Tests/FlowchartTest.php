<?php
/**
 * This file is part of the Petriflow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests;

use Mockery;
use Geomagilles\FlowGraph\Components\Graph\Flow\Graph;

/**
 * Test class for flowchart.
 */
class FlowGraphTest extends BaseTest
{
    public function testConstructor()
    {
        $flowchart =  new FlowGraph();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Components\Graph\GraphInterface', $flowchart);
        $this->assertSame('', $flowchart->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $flowchart->getFlow\GraphFactory());
    }

    public function testAddArcFromBegin()
    {
        $flowchart =  new FlowGraph();
        $input     = Mockery::mock('Geomagilles\FlowGraph\Points\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $box
            ->shouldReceive('getGraph')
            ->andReturn($flowchart);
        $box
            ->shouldReceive('getInputPoint')
            ->andReturn($input);
        $input
            ->shouldReceive('getBox')
            ->andReturn($box);
        $input
            ->shouldReceive('addArc')
            ->once();

        $this->assertCount(0, $this->invokeMethod($flowchart, 'getArcs'));
        $arc = $flowchart->addArcFromBegin($box);
        $arcs = $this->invokeMethod($flowchart, 'getArcs');
        $this->assertCount(1, $arcs);
        $begin = $this->invokeMethod($flowchart, 'getComponent', array('Begin'));
        $this->assertSame($begin, $arcs[0]->getBeginPoint()->getBox());
        $this->assertSame($box, $arcs[0]->getEndPoint()->getBox());
    }

    public function testAddArcToEnd()
    {
        $flowchart =  new FlowGraph();
        $output    = Mockery::mock('Geomagilles\FlowGraph\Points\PointInterface');
        $box       = Mockery::mock('Geomagilles\FlowGraph\Components\ComponentInterface');

        $box
            ->shouldReceive('getGraph')
            ->andReturn($flowchart);
        $box
            ->shouldReceive('getOutputPoint')
            ->andReturn($output);
        $output
            ->shouldReceive('getBox')
            ->andReturn($box);
        $output
            ->shouldReceive('addArc')
            ->once();

        $this->assertCount(0, $this->invokeMethod($flowchart, 'getArcs'));
        $arc = $flowchart->addArcToEnd($box);
        $arcs = $this->invokeMethod($flowchart, 'getArcs');
        $this->assertCount(1, $arcs);
        $end = $this->invokeMethod($flowchart, 'getComponent', array('End'));
        $this->assertSame($box, $arcs[0]->getBeginPoint()->getBox());
        $this->assertSame($end, $arcs[0]->getEndPoint()->getBox());
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddInputPoint()
    {
        $flowchart =  new FlowGraph();
        $input     = Mockery::mock('Geomagilles\FlowGraph\Points\PointInterface');

        $flowchart->addInputPoint($input);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddOutputPoint()
    {
        $flowchart =  new FlowGraph();
        $output    = Mockery::mock('Geomagilles\FlowGraph\Points\PointInterface');

        $flowchart->addOutputPoint($output);
    }

    public function other()
    {
        //$factory = new FlowGraphFactory();
        //$graph = $factory->createGraph('my graph');
//
        //$begin = $graph->addBegin("begin");
        //$flow1 = $graph->addDecision("task1");
        //$complete = $graph->addTask("completed");
        //$failed  = $graph->addTask("failed");
//
        //$graph1 = $graph->addGraph("graph1");
        //$task3 = $graph1->addTask("task3");
        //$task4 = $graph1->addTask("task4");
        //$graph1->addArrow($task3, $task4);
        //$graph1->addInputPoint($task3->getInputPoint());
        //$graph1->addOutputPoint($task4->getOutputPoint());
        //
        //$end = $graph->addEnd("end");
//
        //$graph->addArrow($begin, $task1);
        //$graph->addArrow($task1, $complete, Decision::TASK_COMPLETED);
        //$graph->addArrow($complete, $graph1);
        //
        //$graph->addArrow($task1, $failed, Decision::TASK_FAILED);
        //$graph->addArrow($failed, $graph1);
//
        //$graph->addArrow($graph1, $end);

        // $graph = $graph->addGraph("graph1");
        // $task4 = $graph->addDecision("task4");
        // $task5 = $graph->addTask("task5");
        // $graph->addInputPoint($task4->getInputPoint());
        // $graph->addOutputPoint($task5->getOutputPoint());
        // $graph->addArrow($task4, $task5, 'OnTaskCompleted');

        // $graph->addArrow($task3, $graph);
        // $graph->addArrow($graph, $task2);

        // Creating a file Network.dot ready to be opened by the Graphviz software
        //$dumper = new GraphvizDumper();
        ////file_put_contents('flowchart.dot', $dumper->dump($graph));

//        //// Creating a file Network.dot ready to be opened by the Graphviz software
        //$dumper = new \Petrinet\Dumper\GraphvizDumper();
        //$petrinet = $graph->getPetriBuilder()->getPetrinet();
        ////file_put_contents('petrinet1.dot', $dumper->dump($petrinet));

//        //$engine = new Engine($petrinet);
        //$dispatcher = new EventDispatcher();
        //
        //// Listening to an EngineEvent
        //$stopped = function (EngineEvent $e) use ($dumper) {
        //    $petrinet = $e->getEngine()->getPetrinet();
        //    echo 'The execution of the Petrinet ' . $petrinet->getId() . ' just stopped';
        //    file_put_contents('petrinet2.dot', $dumper->dump($petrinet));
        //};
        //$listenInsertion = function (TokenAndPlaceEvent $e) {
        //    $placeId = $e->getToken()->getId();
        //    echo sprintf('The place %s just received a new token', $placeId);
        //};

//        //// Adding the listener to the dispatcher
        //$dispatcher->addListener(PetrinetEvents::AFTER_ENGINE_STOP, $stopped);
        //$dispatcher->addListener(PetrinetEvents::AFTER_TOKEN_INSERT, $listenInsertion);

//        //// Injecting the dispatcher into the engine
        //$engine->setDispatcher($dispatcher);
        //
        //// Starting the execution
        //$engine->start();

//        //$this->assertInstanceOf('\Flow\Graph\Components\Graph\Graph', $graph);
    }
}
