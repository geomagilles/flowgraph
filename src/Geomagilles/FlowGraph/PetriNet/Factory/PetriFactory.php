<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Factory;

use Geomagilles\FlowGraph\PetriNet\PetriNet;
use Geomagilles\FlowGraph\PetriNet\Token\Token;
use Geomagilles\FlowGraph\PetriNet\Builder\PetriBuilder;
use Geomagilles\FlowGraph\PetriNet\Arc\Arc;
use Geomagilles\FlowGraph\PetriNet\Transition\Transition;
use Geomagilles\FlowGraph\PetriNet\Transition\TransitionInterface;
use Geomagilles\FlowGraph\PetriNet\Place\PlaceInterface;
use Geomagilles\FlowGraph\PetriNet\Place\Place;

class PetriFactory implements PetriFactoryInterface
{
    public function createBuilder()
    {
        return new PetriBuilder($this);
    }

    public function createPetrinet($id)
    {
        return new PetriNet($id);
    }

    public function createArcPT($id, PlaceInterface $place, TransitionInterface $transition)
    {
        return new Arc($id, Arc::PLACE_TO_TRANSITION, $place, $transition);
    }

    public function createArcTP($id, TransitionInterface $transition, PlaceInterface $place)
    {
        return new Arc($id, Arc::TRANSITION_TO_PLACE, $place, $transition);
    }

    public function createTransition($id)
    {
        return new Transition($id);
    }

    public function createPlace($id)
    {
        return new Place($id);
    }

    public function createToken($id)
    {
        return new Token($id);
    }
}
