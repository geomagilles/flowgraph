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

use Geomagilles\FlowGraph\Components\Begin\BeginInterface;
use Geomagilles\FlowGraph\PetriNet\factory\PetriBuilderInterface;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

class PetriBegin extends PetriBox implements PetriBoxInterface
{
    /**
     * Name of begin place
     * @var string
     */
    const PLACE_BEGIN = 'begin';


    public function __construct(BeginInterface $begin, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($begin, $petriBoxFactory);
        // place
        $begin = $this->addBeginPlace();
        // arc
        $this->addArc($begin, $this->getOutputTransition());
        // reset state
        $this->resetState();
    }

    public function resetState()
    {
        // reset all tokens
        parent::resetState();
        
        // add a token to begin place
        $this->addTokenToPlace(self::PLACE_BEGIN);
    }

    protected function addBeginPlace()
    {
        return $this->addPlace(self::PLACE_BEGIN)->setBegin(true);
    }
}
