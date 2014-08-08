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
use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;

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

    //
    // INPUT POINTS
    //

    public function createInputPoint($name = '')
    {
        $point = $this->factory->createInputPoint($name);
        $this->addInputPoint($point);

        return $point;
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

    public function createOutputPoint($name = '')
    {
        $point = $this->factory->createOutputPoint($name);
        $this->addOutputPoint($point);
        
        return $point;
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
    // TRIGGER POINTS
    //

    public function addTriggerPoint(TriggerPointInterface $point)
    {
        $name = $point->getName();
        if (! $this->hasTriggerPoint($name)) {
            $this->triggerPoints[$name] = $point;
            $point->setBox($this);
        } else {
            throw new \LogicException(
                sprintf('Box "%s" already has a trigger point with name "%s"', $this->getName(), $name)
            );
        }

        return $this;
    }

    public function createTriggerPoint($name = '')
    {
        $point = $this->factory->createTriggerPoint($name);
        $this->addTriggerPoint($point);

        return $point;
    }

    public function getTriggerPoints()
    {
        return $this->triggerPoints;
    }

    public function hasTriggerPoint($name = '')
    {
        return isset($this->triggerPoints[$name]);
    }

    public function getTriggerPoint($name = '')
    {
        if ($this->hasTriggerPoint($name)) {
            return $this->triggerPoints[$name];
        }
        throw new \LogicException(
            sprintf('Box "%s" does not have any trigger point with name "%s"', $this->getName(), $name)
        );
    }

    // HELPERS

    public function input($name)
    {
        return array($this, $this->getInputPoint($name));
    }

    public function output($name)
    {
        return array($this, $this->getOutputPoint($name));
    }

    public function trigger($name)
    {
        return array($this, $this->getTriggerPoint($name));
    }
}
