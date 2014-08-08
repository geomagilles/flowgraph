<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Builder;

use Geomagilles\FlowGraph\Factory\GraphFactoryInterface;
use Geomagilles\FlowGraph\Factory\GraphFactory;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Point\PointInterface;

class GraphBuilder implements GraphBuilderInterface
{
    /**
     * The graph to build
     * @var FlowGraph\GraphInterface
     */
    private $graph;

    /**
     * The Graph factory
     * @var FlowGraph\Factory\GraphFactoryInterface
     */
    private $factory;

    public function __construct($name = '', GraphFactoryInterface $factory = null)
    {
        $this->factory = is_null($factory) ? new GraphFactory() : $factory;
        $this->graph = $this->factory->createGraph($name);
    }

    private function createName()
    {
        return uniqid();
    }

    public function getGraph()
    {
        return $this->graph;
    }

    public function graph($name)
    {
        $graph = $this->factory->createGraph($name);
        $this->graph->addBox($graph);
        
        return $graph;
    }

    public function synchronizer()
    {
        $synchronizer = $this->factory->createSynchronizer($this->createName());
        $this->graph->addBox($synchronizer);
        
        return $synchronizer;
    }

    public function task($job)
    {
        $task = $this->factory->createTask($this->createName())
            ->setJob($job)
            ->withOutput('');
        $this->graph->addBox($task);
        
        return $task;
    }

    public function wait($job = null)
    {
        $wait = $this->factory->createWait($this->createName())
            ->setJob($job)
            ->withOutput('');
        $this->graph->addBox($wait);
        
        return $wait;
    }

    public function begin()
    {
        $begin = $this->factory->createBegin($this->createName());
        $this->graph->addBox($begin);
        
        return $begin;
    }

    public function end()
    {
        $end = $this->factory->createEnd($this->createName());
        $this->graph->addBox($end);
        
        return $end;
    }

    public function connect($begin, $end)
    {
        if (! is_array($begin)) {
            $begin = $begin->output('');
        }
        if (! is_array($end)) {
            $end = $end->input('');
        }

        // get output point
        $outputPoint = $begin[1];

        // get input point
        if ($this->factory->isSynchronizer($end[0])) {
            $inputPoint = $end[0]->createInputPoint($end[1]);
        } else {
            $inputPoint = $end[1];
        }
        // create and add arc
        $arc = $this->factory->createArc($outputPoint, $inputPoint);
        $this->graph->addArc($arc);

        return $this;
    }

    /**
     * Clone a input ou output point of a box to become point of this graph.
     * @param PointInterface $point
     * @param string         $name
     * @throws \LogicException
     * @return pointInterface
     */
    protected function clonePoint(PointInterface $point, $name = null)
    {
        // define name of the new point for this graph
        $name = is_null($name) ? $point->getName() : $name;
        // create new point
        $graphPoint = $this->factory->createPoint($name);
        // links this point to subjascent box's point
        $graphPoint->setSubjacentPoint($point);

        return $graphPoint;
    }

    public function addInputPoint(PointInterface $point, $name = null)
    {
        $this->graph->addInputPoint($this->clonePoint($point, $name));
    }

    public function addOutputPoint(PointInterface $point, $name = null)
    {
        $this->graph->addOutputPoint($this->clonePoint($point, $name));
    }
}
