<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Box;

use Geomagilles\FlowGraph\Element\Element;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\Points\PointInterface;
use Geomagilles\FlowGraph\Points\InputPointInterface;
use Geomagilles\FlowGraph\Points\OutputPointInterface;

/**
 * The Box class.
 */
abstract class Box extends Element implements BoxInterface
{

    abstract public function createIO();

    // PARENT GRAPH

    /**
     * The graph owning this box.
     * @var Geomagilles\FlowGraph\GraphInterface|null
     */
    protected $parentGraph = null;

    public function getParentGraph()
    {
        return $this->parentGraph;
    }

    public function setParentGraph(GraphInterface $graph)
    {
        $this->parentGraph = $graph;
    }

    // INTROSPECTION

    public function getType()
    {
        return ($this->factory->getType($this));
    }

    public function isGraph()
    {
        return ($this->factory->isGraph($this));
    }

    public function isBegin()
    {
        return ($this->factory->isBegin($this));
    }

    public function isEnd()
    {
        return ($this->factory->isEnd($this));
    }

    public function isSynchronizer()
    {
        return ($this->factory->isSynchronizer($this));
    }

    public function isTask()
    {
        return ($this->factory->isTask($this));
    }

    public function isWait()
    {
        return ($this->factory->isWait($this));
    }

    //
    // INPUT POINTS
    //

    /**
     * The input points.
     * @var Geomagilles\FlowGraph\PointsInterface[]
     */
    protected $inputPoints = array();

    public function addInputPoint(InputPointInterface $point)
    {
        $name = $point->getName();
        if (! $this->hasInputPoint($name)) {
            $this->inputPoints[$name] = $point;
            $point->setBox($this);
        } else {
            throw new \LogicException(
                sprintf('Box "%s" already has an input point with name "%s"', $this->getName(), $name)
            );
        }

        return $this;
    }

    public function getInputPoints()
    {
        return $this->inputPoints;
    }

    public function hasInputPoint($name = '')
    {
        return isset($this->inputPoints[$name]);
    }

    public function getInputPoint($name = '')
    {
        if ($this->hasInputPoint($name)) {
            return $this->inputPoints[$name];
        }
        throw new \LogicException(
            sprintf('Box "%s" does not have any input point with name "%s"', $this->getName(), $name)
        );
    }

    //
    // OUTPUT POINTS
    //

    /**
     * The output points.
     * @var Geomagilles\FlowGraph\PointsInterface[]
     */
    protected $outputPoints = array();

    public function addOutputPoint(OutputPointInterface $point)
    {
        $name = $point->getName();
        if (! $this->hasOutputPoint($name)) {
            $this->outputPoints[$name] = $point;
            $point->setBox($this);
        } else {
            throw new \LogicException(
                sprintf('Box "%s" already has an output points with name "%s"', $this->getName(), $name)
            );
        }

        return $this;
    }

    public function getOutputPoints()
    {
        return $this->outputPoints;
    }

    public function hasOutputPoint($name = '')
    {
        return isset($this->outputPoints[$name]);
    }

    public function getOutputPoint($name = '')
    {
        if ($this->hasOutputPoint($name)) {
            return $this->outputPoints[$name];
        }
        throw new \LogicException(
            sprintf('Box "%s" does not have any output point with name "%s"', $this->getName(), $name)
        );
    }

    //
    // HELPERS
    //

    public function hasJob()
    {
        return false;
    }

    public function input($name)
    {
        return array($this, $this->getInputPoint($name));
    }

    public function output($name)
    {
        return array($this, $this->getOutputPoint($name));
    }
}
