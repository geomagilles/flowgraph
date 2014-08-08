<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Point;

use Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface;
use Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface;
use Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface;
use Geomagilles\FlowGraph\Point\PointInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Arc\ArcInterface;
use Geomagilles\FlowGraph\Element\Element;

abstract class Point extends Element implements PointInterface
{
    /**
     * The box that owns this point.
     *
     * @var BoxInterface
     */
    protected $box;

    /**
     * The (optional) subjacent point.
     *
     * @var PointInterface
     */
    protected $subjacentPoint = null;

    /**
     * The arcs linked to this box.
     *
     * @var ArcInterface[]
     */
    protected $arcs = array();

    public function isInput()
    {
        return $this instanceof InputPointInterface;
    }

    public function isOutput()
    {
        return $this instanceof OutputPointInterface;
    }

    public function isTrigger()
    {
        return $this instanceof TriggerPointInterface;
    }

    public function setBox(BoxInterface $box)
    {
        $this->box = $box;

        return $this;
    }

    public function getBox()
    {
        return $this->box;
    }

    public function setSubjacentPoint(PointInterface $subjacentPoint)
    {
        $this->subjacentPoint = $subjacentPoint;

        return $this;
    }

    public function getSubjacentPoint()
    {
        return $this->subjacentPoint;
    }

    public function addArc(ArcInterface $arc)
    {
        if (($arc->getBeginPoint() != $this) && ($arc->getEndPoint() != $this)) {
            throw new \LogicException(
                sprintf('an arc MUST begin or finish to a point to be added to it')
            );
        } elseif (! in_array($arc, $this->getArcs(), true)) {
            $this->arcs[] = $arc;
        }

        return $this;
    }

    public function getArcs()
    {
        return $this->arcs;
    }

    public function countArcs()
    {
        return count($this->getArcs());
    }

    public function hasAnyArc()
    {
        return $this->countArcs() > 0;
    }
}
