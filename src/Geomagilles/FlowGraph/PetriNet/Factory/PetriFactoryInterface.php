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

use Petrinet\PetrinetInterface;
use Petrinet\Arc\ArcInterface;
use Geomagilles\FlowGraph\PetriNet\Transition\TransitionInterface;
use Geomagilles\FlowGraph\PetriNet\Place\PlaceInterface;
use Petrinet\Token\Token;

/**
 * Interface for PetriNet.
 */
interface PetriFactoryInterface
{
    /**
     * Creates a new petri builder.
     * @return PetriBuilderInterface
     */
    public function createBuilder();

    /**
     * Creates a new petrinet.
     * @param $id
     * @return PetrinetInterface
     */
    public function createPetrinet($id);

    /**
     * Creates a new arc between a place and a transition.
     * @param                     $id
     * @param PlaceInterface      $place
     * @param TransitionInterface $transition
     * @return ArcInterface
     */
    public function createArcPT($id, PlaceInterface $place, TransitionInterface $transition);

    /**
     * Creates a new arc between a transition and a place.
     * @param                     $id
     * @param TransitionInterface $transition
     * @param PlaceInterface      $place
     * @return ArcInterface
     */
    public function createArcTP($id, TransitionInterface $transition, PlaceInterface $place);

    /**
     * Creates a new transition.
     * @param $id
     * @return TransitionInterface
     */
    public function createTransition($id);

    /**
     * Creates a new place.
     * @param mixed $id
     * @return PlaceInterface
     */
    public function createPlace($id);

    /**
     * Creates a new token.
     * @param $id
     * @return Token
     */
    public function createToken($id);
}
