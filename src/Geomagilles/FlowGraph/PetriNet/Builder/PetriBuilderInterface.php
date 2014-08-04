<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Builder;

use Geomagilles\FlowGraph\PetriNet\Place\PlaceInterface;
use Geomagilles\FlowGraph\PetriNet\Transition\TransitionInterface;
use Geomagilles\FlowGraph\PetriNet\Arc\ArcInterface;
use Geomagilles\FlowGraph\PetriNet\Token\TokenInterface;
use Geomagilles\FlowGraph\PetriNet\PetriNetInterface;

use Petrinet\Node\NodeInterface;

/**
 * Interface for building petrinet.
 */
interface PetriBuilderInterface
{
    /**
     * Gets the petriNet.
     * 
     * @return PetriNetInterface
     */
    public function getPetriNet();

    /**
     * Adds a place.
     * @param int $nbtoken Number of tokens in it
     * @return PlaceInterface
     */
    public function addPlace($nbtoken = 0, $id = null);

    /**
     * Set number of token in a place.
     * @param PlaceInterface $place
     * @param integer $tokens number of tokens
     */
    public function setTokenToPlace(PlaceInterface $place, $tokens = 0);

    /**
     * Adds some tokens to a place.
     * @param PlaceInterface $place
     * @param integer $tokens number of tokens to add
     */
    public function addTokenToPlace(PlaceInterface $place, $tokens = 1);

    /**
     * Adds a Transition.
     * 
     * @return TransitionInterface
     */
    public function addTransition($id = null);

    /**
     * Adds a arc between two nodes.
     * @param NodeInterface $begin
     * @param NodeInterface $end
     * @throws LogicException if nodes are not a place and a transition 
     * @return ArcInterface
     */
    public function addArc(NodeInterface $begin, NodeInterface $end, $id = null);
}
