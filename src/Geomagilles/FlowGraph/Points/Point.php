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

use Geomagilles\FlowGraph\Points\InputPointInterface;
use Geomagilles\FlowGraph\Points\OutputPointInterface;
use Geomagilles\FlowGraph\Points\PointInterface;
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
        return $this->factory->isInputPoint($this);
    }

    public function isOutput()
    {
        return $this->factory->isOutputPoint($this);
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

    public function hasAnyArc()
    {
        return count($this->getArcs()) > 0;
    }
}
