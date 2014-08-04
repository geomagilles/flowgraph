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

class Arc extends \Petrinet\Arc\Arc implements ArcInterface
{
    /**
     * The box owning this Arc
     * @var BoxInterface
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
}
