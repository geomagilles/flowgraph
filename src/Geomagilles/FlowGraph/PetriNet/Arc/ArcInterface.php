<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Arc;

use Geomagilles\FlowGraph\Box\BoxInterface;

interface ArcInterface extends \Petrinet\Arc\ArcInterface
{
    public function getBox();

    public function setBox(BoxInterface $box);
}
