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

use Geomagilles\FlowGraph\PetriNet\Factory\PetriFactoryInterface;
use Geomagilles\FlowGraph\PetriNet\Factory\PetriFactory;
use Geomagilles\FlowGraph\PetriNet\PetrinetInterface;
use Geomagilles\FlowGraph\PetriNet\Place\PlaceInterface;
use Geomagilles\FlowGraph\PetriNet\Transition\TransitionInterface;
use Petrinet\Node\NodeInterface;

/**
 * Class for building petrinet.
 */
class PetriBuilder implements PetriBuilderInterface
{
    /**
     * The Petri factory.
     * @var PetriFactoryInterface
     */
    private $factory;

    /**
     * The petrinet.
     * @var PetriNetInterface
     */
    private $petrinet;

    /**
     * Used to create petrinet.
     * @param PetriFactoryInterface $factory
     * @param mixed                  $id
     */
    public function __construct(PetriFactoryInterface $factory = null, $id = null)
    {
        $this->factory  = is_null($factory) ? new PetriFactory() : $factory;
        $this->petrinet = $this->factory->createPetrinet($this->getUniqueId($id));
    }

    protected function getUniqueId($id = null)
    {
        return is_null($id) ? uniqid('id_') : $id;
    }

    public function getPetrinet()
    {
        return $this->petrinet;
    }

    public function setTokenToPlace(PlaceInterface $place, $tokens = 0)
    {
        $place->clearTokens();
        $this->addTokenToPlace($place, $tokens);
    }

    public function addTokenToPlace(PlaceInterface $place, $tokens = 1)
    {
        while ($tokens > 0) {
            $token = $this->factory->createToken($this->getUniqueId());
            $place->addToken($token);
            $tokens--;
        }
    }

    public function addPlace($nbtoken = 0, $id = null)
    {
        $place = $this->factory->createPlace($this->getUniqueId($id));
        while ($nbtoken>0) {
            $this->addTokenToPlace($place);
            $nbtoken--;
        }
        $this->petrinet->addPlace($place);
        
        return $place;
    }

    public function addTransition($id = null)
    {
        $transition = $this->factory->createTransition($this->getUniqueId($id));
        $this->petrinet->addTransition($transition);
        
        return $transition;
    }

    public function addArc(NodeInterface $begin, NodeInterface $end, $id = null)
    {
        if (($begin instanceof PlaceInterface) && ($end instanceof TransitionInterface)) {
            return $this->addArcPT($begin, $end, $id);
        } elseif (($begin instanceof TransitionInterface) && ($end instanceof PlaceInterface)) {
            return $this->addArcTP($begin, $end, $id);
        } else {
            throw new \LogicException('An arc MUST be between a place and a transition');
        }
    }

    /**
     * Adds a arc from a place to a transition.
     * @param PlaceInterface      $place
     * @param TransitionInterface $transition
     * @return ArcInterface
     */
    protected function addArcPT(PlaceInterface $place, TransitionInterface $transition, $id = null)
    {
        $arc = $this->factory->createArcPT($this->getUniqueId($id), $place, $transition);
        $this->petrinet->addArc($arc);
        $place->addOutputArc($arc);
        $transition->addInputArc($arc);
        
        return $arc;
    }

    /**
     * Adds a arc from a transition to a place.
     * @param TransitionInterface $transition
     * @param PlaceInterface      $place
     * @return ArcInterface
     */
    protected function addArcTP(TransitionInterface $transition, PlaceInterface $place, $id = null)
    {
        $arc = $this->factory->createArcTP($this->getUniqueId($id), $transition, $place);
        $this->petrinet->addArc($arc);
        $transition->addOutputArc($arc);
        $place->addInputArc($arc);
        
        return $arc;
    }

    public function merge(PetriNetInterface $othernet)
    {
        // merge Places
        foreach ($othernet->getPlaces() as $place) {
            $this->petrinet->addPlace($place);
        }
                
        // merge Transitions
        foreach ($othernet->getTransitions() as $transition) {
            $this->petrinet->addTransition($transition);
        }
        
        // merge Arcs
        foreach ($othernet->getArcs() as $arc) {
            $this->petrinet->addArc($arc);
        }

        return $this;
    }
}
