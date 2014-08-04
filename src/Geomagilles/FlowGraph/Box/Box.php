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

use Geomagilles\FlowGraph\Point\PointInterface;
use Geomagilles\FlowGraph\Element\Element;
use Geomagilles\FlowGraph\GraphInterface;

/**
 * The Box class.
 */
abstract class Box extends Element implements BoxInterface
{
    /**
     * The input points.
     * @var PointInterface[]
     */
    protected $inputPoints = array();

    /**
     * The output points.
     * @var PointInterface[]
     */
    protected $outputPoints = array();

    /**
     * The graph owning this box.
     * @var GraphInterface|null
     */
    protected $parentGraph = null;

    abstract public function createIO();

    public function getParentGraph()
    {
        return $this->parentGraph;
    }

    public function setParentGraph(GraphInterface $graph)
    {
        $this->parentGraph = $graph;
    }

    public function isGraph()
    {
        return ($this->factory->isGraph($this));
    }

    public function getType()
    {
        return ($this->factory->getType($this));
    }

    public function hasJob()
    {
        return false;
    }

    public function addInputPoint(PointInterface $point)
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

    public function addOutputPoint(PointInterface $point)
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
    
    public function createOutputPoint($name = '')
    {
        $point = $this->factory->createPoint($name);
        $this->addOutputPoint($point);
        
        return $point;
    }

    public function createInputPoint($name = '')
    {
        $point = $this->factory->createPoint($name);
        $this->addInputPoint($point);

        return $point;
    }

    public function getInputPoints()
    {
        return $this->inputPoints;
    }

    public function hasAnyInputPoint()
    {
        return count($this->inputPoints) > 0;
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

    public function getOutputPoints()
    {
        return $this->outputPoints;
    }

    public function hasAnyOutputPoint()
    {
        return count($this->outputPoints) > 0;
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
}
