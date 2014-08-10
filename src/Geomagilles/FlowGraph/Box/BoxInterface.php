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

use Geomagilles\FlowGraph\Points\InputPointInterface;
use Geomagilles\FlowGraph\Points\OutputPointInterface;
use Geomagilles\FlowGraph\Points\TriggerPoint\TriggerPointInterface;
use Geomagilles\FlowGraph\Element\ElementInterface;
use Geomagilles\FlowGraph\GraphInterface;

/**
 * Interface for boxes.
 */
interface BoxInterface extends ElementInterface
{
    /**
     * Is this box a graph itself?
     * @return boolean
     */
    public function isGraph();

    /**
     * Gets the graph that owns this component (if any).
     * @return Geomagilles\FlowGraph\GraphInterface|null
     */
    public function getParentGraph();

    /**
     * Sets the graph that owns this box.
     * @param Geomagilles\FlowGraph\GraphInterface $graph
     */
    public function setParentGraph(GraphInterface $graph);

    /**
     * Has this box a job?
     * @return boolean 
     */
    public function hasJob();

    /**
     * Has this box an input point of name $name?
     * @param string $name
     * @return boolean
     */
    public function hasInputPoint($name = '');

    /**
     * Gets all input points.
     * @return Geomagilles\FlowGraph\Points\InputPointInterface[]
     */
    public function getInputPoints();
    
    /**
     * Get input point by name.
     * @param string $name
     * @return Geomagilles\FlowGraph\Points\InputPointInterface
     * @throws \InvalidArgumentException
     */
    public function getInputPoint($name = '');

    /**
     * Adds an input point.
     * @param Geomagilles\FlowGraph\Points\InputPointInterface $point
     * @return self
     * @throws \LogicException
     */
    public function addInputPoint(InputPointInterface $point);

    /**
     * Has this box an output point of name $name?
     * @param string $name
     * @return boolean
     */
    public function hasOutputPoint($name = '');

    /**
     * Gets all output points.
     * @return Geomagilles\FlowGraph\Points\OutputPointInterface[]
     */
    public function getOutputPoints();

    /**
     * Get output point by name.
     * @param string $name
     * @return Geomagilles\FlowGraph\Points\OutputPointInterface
     * @throws \InvalidArgumentException
     */
    public function getOutputPoint($name = '');

    /**
     * Adds an output point.
     * @param Geomagilles\FlowGraph\Points\OutputPointInterface $point
     * @throws \LogicException
     * @return self
     */
    public function addOutputPoint(OutputPointInterface $point);
}
