<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph;

use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Arc\ArcInterface;
use Geomagilles\FlowGraph\Points\PointInterface;
use Geomagilles\FlowGraph\Points\InputPointInterface;
use Geomagilles\FlowGraph\Points\OutputPointInterface;

/**
 * Class representing a sub-network of a FlowGraph.
 */
class Graph extends Box implements GraphInterface
{
    /**
     * The boxes of this graph.
     * @var BoxInterface[]
     */
    protected $boxes = array();

    /**
     * The arcs.
     * @var ArcInterface[]
     */
    protected $arcs = array();
    
    public function createIO()
    {
        // nothing to do per default
    }

    public function addBox(BoxInterface $box)
    {
        if ($this->checkBox($box)) {
            $this->boxes[$box->getName()] = $box;
            $box->setParentGraph($this);
        }
        
        return $box;
    }

    private function checkBox(BoxInterface $box)
    {
        if ($box->isGraph()) {
            $graph = $this;
            while (! is_null($graph)) {
                if ($graph == $box) {
                    throw new \LogicException('You can NOT add a graph to itself');
                }
                $graph = $graph->getParentGraph();
            }
        }
        if (! is_null($this->getBox($box->getName()))) {
            throw new \LogicException('There is already another box with same name in this graph');
        }

        return true;
    }
    
    public function getBoxes()
    {
        return $this->boxes;
    }

    public function getBoxById($id)
    {
        foreach ($this->boxes as $name => $box) {
            if ($box->isGraph()) {
                $found = $box->getBoxById($id);
                if (! is_null($found)) {
                    return $found;
                }
            } elseif ($box->getId() === $id) {
                return $box;
            }
        }
        return null;
    }

    public function getBox($name)
    {
        if (isset($this->boxes[$name])) {
            return $this->boxes[$name];
        }
        return null;
    }

    public function addArc(ArcInterface $arc)
    {
        if ($this->checkArc($arc)) {
            $this->arcs[] = $arc;
        }

        return $arc;
    }
    
    private function checkArc(ArcInterface $arc)
    {
        $point = $arc->getBeginPoint();
        if (is_null($point->getBox()) || ($point->getBox()->getParentGraph() != $this)) {
            throw new \LogicException(
                sprintf(
                    'You can NOT add an arc whose begin point "%s" is in a box (if any) that is NOT in graph "%s"',
                    $point->getName(),
                    $this->getName()
                )
            );
        }
        $point = $arc->getEndPoint();
        if (is_null($point->getBox()) || ($point->getBox()->getParentGraph() != $this)) {
            throw new \LogicException(
                sprintf(
                    'You can NOT add an arc whose end point "%s" is in a box (if any) that is NOT in graph "%s"',
                    $point->getName(),
                    $this->getName()
                )
            );
        }

        return true;
    }

    public function getArcs()
    {
        return $this->arcs;
    }

    public function addInputPoint(InputPointInterface $point)
    {
        if ($point->checkPoint($point)) {
            parent::addInputPoint($point);
        }
    }

    public function addOutputPoint(OutputPointInterface $point)
    {
        if ($point->checkPoint($point)) {
            parent::addOutputPoint($point);
        }
    }

    private function checkPoint(PointInterface $point)
    {
        $sub = $point->getSubjacentPoint();
        if (is_null($sub) || is_null($sub->getBox()) || ($sub->getBox()->getGraph() != $this)) {
            throw new \LogicException(
                sprintf(
                    'You can NOT add point "%s" whose box (if any) is NOT in graph "%s"',
                    $point->getName(),
                    $this->getName()
                )
            );
        }

        return true;
    }
}
