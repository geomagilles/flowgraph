<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\PetriComponents;

use Geomagilles\FlowGraph\Components\End\EndInterface;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

class PetriEnd extends PetriBox implements PetriBoxInterface
{
    /**
     * The name of 'end' place
     * @var string
     */
    const PLACE_END = 'end';

    public function __construct(EndInterface $end, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($end, $petriBoxFactory);
        // place
        $end = $this->addEndPlace();
        // arc
        $this->addArc($this->getInputTransition(), $end);
        // reset state
        $this->resetState();
    }

    protected function addEndPlace()
    {
        return $this->addPlace(self::PLACE_END)->setEnd(true);
    }
}
