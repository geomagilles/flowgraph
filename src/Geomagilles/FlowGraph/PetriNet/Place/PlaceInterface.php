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

interface PlaceInterface extends \Petrinet\Place\PlaceInterface
{
    public function getBox();

    public function setBox(BoxInterface $box);

    public function isBegin();

    public function setBegin($isBegin);

    public function isEnd();

    public function setEnd($isEnd);

    public function isTrigger();

    public function setTrigger($isTrigger);
}
