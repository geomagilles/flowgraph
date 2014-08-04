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

use Geomagilles\FlowGraph\Point\PointInterface;
use Geomagilles\FlowGraph\Element\Element;

/**
 * Represents an arc.
 */
class Arc extends Element implements ArcInterface
{
    /**
     * The begin point.
     * @var PointInterface
     */
    protected $beginPoint;

    /**
     * The end point.
     * @var PointInterface
     */
    protected $endPoint;

    public function setBeginPoint(PointInterface $point)
    {
        $this->beginPoint = $point;
        $point->addArc($this);

        return $point;
    }

    public function setEndPoint(PointInterface $point)
    {
        $this->endPoint = $point;
        $point->addArc($this);
        
        return $point;
    }

    public function getBeginPoint()
    {
        return $this->beginPoint;
    }

    public function getEndPoint()
    {
        return $this->endPoint;
    }
}
