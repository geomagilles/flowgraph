<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Place;

use Geomagilles\FlowGraph\Box\BoxInterface;

class Place extends \Petrinet\Place\Place implements PlaceInterface
{
    /**
     * Is this place the begin of a graph?
     * @var boolean
     */
    protected $isBegin = false;

    /**
     * Is this place the end of a graph?
     * @var boolean
     */
    protected $isEnd = false;

    /**
     * Is this place a trigger?
     * @var boolean
     */
    protected $isTrigger = false;

    /**
     * The box owning this Place
     * @var ComponentInterface
     */
    protected $box;

    public function getBox()
    {
        return $this->box;
    }

    public function setBox(BoxInterface $box)
    {
        $this->box = $box;
        
        return $this;
    }

    public function isBegin()
    {
        return $this->isBegin;
    }

    public function setBegin($isBegin)
    {
        if (! is_bool($isBegin)) {
            throw new \InvalidArgumentException('$isBegin MUST be a boolean');
        }
        $this->isBegin = $isBegin;
        return $this;
    }

    public function isEnd()
    {
        return $this->isEnd;
    }

    public function setEnd($isEnd)
    {
        if (! is_bool($isEnd)) {
            throw new \InvalidArgumentException('$isEnd MUST be a boolean');
        }
        $this->isEnd = $isEnd;
        return $this;
    }

    public function isTrigger()
    {
        return $this->isTrigger;
    }

    public function setTrigger($isTrigger)
    {
        if (! is_bool($isTrigger)) {
            throw new \InvalidArgumentException('$isTrigger MUST be a boolean');
        }
        $this->isTrigger = $isTrigger;
        return $this;
    }
}
