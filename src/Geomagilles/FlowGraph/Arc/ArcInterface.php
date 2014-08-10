<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Arc;

use Geomagilles\FlowGraph\Points\PointInterface;
use Geomagilles\FlowGraph\Element\ElementInterface;

/**
 * Interface for digraph arc.
 */
interface ArcInterface extends ElementInterface
{
    /**
     * Sets the begin point.
     * @param PointInterface $point
     * @return PointInterface
     */
    public function setBeginPoint(PointInterface $point);

    /**
     * Sets the end point.
     * @param PointInterface $point
     * @return PointInterface
     */
    public function setEndPoint(PointInterface $point);

    /**
     * Gets the begin point.
     * @return PointInterface
     */
    public function getBeginPoint();

    /**
     * Gets the end point.
     * @return PointInterface
     */
    public function getEndPoint();
}
