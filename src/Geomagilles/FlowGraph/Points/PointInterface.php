<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Points;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Arc\ArcInterface;
use Geomagilles\FlowGraph\Element\ElementInterface;

/**
 * Interface for points.
 */
interface PointInterface extends ElementInterface
{
    /**
     * Set the box that owns this point.
     * 
     * @param BoxInterface 
     */
    public function setBox(BoxInterface $box);

    /**
     * Get the box that owns this point.
     *
     * @return BoxInterface 
     */
    public function getBox();

    /**
     * Sets the subjacent point corresponding to this point in a graph.
     *
     * @param PointInterface $subjacentPoint
     */
    public function setSubjacentPoint(PointInterface $subjacentPoint);

    /**
     * Gets the box corresponding to this point in a graph.
     *
     * @return PointInterface 
     */
    public function getSubjacentPoint();

    /**
     * Adds an arc.
     *
     * @param ArcInterface $arc
     * @throws \LogicException if $arc is not related to this point
     */
    public function addArc(ArcInterface $arc);

    /**
     * Gets the arcs related to this point.
     *
     * @return ArcInterface[]
     */
    public function getArcs();

    /**
     * Has the point at least one arc?
     *
     * @return boolean
     */
    public function hasAnyArc();
}
