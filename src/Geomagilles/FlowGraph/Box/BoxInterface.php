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
use Geomagilles\FlowGraph\Element\ElementInterface;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\PetriNet\Net\PetriNetInterface;
use Geomagilles\FlowGraph\PetriNet\Factory\PetriFactoryInterface;

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
     * @return GraphInterface|null
     */
    public function getParentGraph();

    /**
     * Sets the graph that owns this box.
     * @param GraphInterface $graph
     */
    public function setParentGraph(GraphInterface $graph);

    /**
     * Has this box a job?
     * @return boolean 
     */
    public function hasJob();

    /**
     * Has this box at least one input point?
     * @return boolean
     */
    public function hasAnyInputPoint();

    /**
     * Has this box an input point of name $name?
     * @param string $name
     * @return boolean
     */
    public function hasInputPoint($name = '');

    /**
     * Gets all input points.
     * @return PointInterface[]
     */
    public function getInputPoints();
    
    /**
     * Get input point by name.
     * @param string $name
     * @return PointInterface
     * @throws \InvalidArgumentException
     */
    public function getInputPoint($name = '');

    /**
     * Adds an input point.
     * @param PointInterface $point
     * @throws \LogicException
     * @return self
     */
    public function addInputPoint(PointInterface $point);

    /**
     * Create and add an input point
     * @param string $name
     * @throws \LogicException
     * @return PointInterface
     */
    public function createInputPoint($name = '');

    /**
     * Has this box at least one output point?
     * @return boolean
     */
    public function hasAnyOutputPoint();

    /**
     * Has this box an output point of name $name?
     * @param string $name
     * @return boolean
     */
    public function hasOutputPoint($name = '');

    /**
     * Gets all output points.
     * @return PointInterface[]
     */
    public function getOutputPoints();

    /**
     * Get output point by name.
     * @param string $name
     * @return PointInterface
     * @throws \InvalidArgumentException
     */
    public function getOutputPoint($name = '');

    /**
     * Adds an output point.
     * @param PointInterface $point
     * @throws \LogicException
     * @return self
     */
    public function addOutputPoint(PointInterface $point);

    /**
     * Create and add an output point
     * @param string $name
     * @throws \LogicException
     * @return PointInterface
     */
    public function createOutputPoint($name = '');
}
