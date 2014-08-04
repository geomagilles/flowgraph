<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\PetriBox;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\Petri\factory\PetriBuilderInterface;
use Geomagilles\FlowGraph\Petri\factory\PetriFactory;

abstract class PetriBox implements PetriBoxInterface
{
    const BOX_NAME      = 'box';
    const BOX_STATE     = 'state';
    const PLACE_NAME    = 'place';
    const PLACE_TOKEN   = 'token';

    /**
     * The petri builder
     * @var PetriBuilderInterface
     */
    protected $petri;

    /**
     * The box
     * @var BoxInterface
     */
    protected $box;

    /**
     * The array of Petri places.
     * @var PlaceInterface[]
     */
    protected $places = array();

    /**
     * The input transitions.
     * @var TransitionInterface[]
     */
    protected $inputTransitions = array();

    /**
     * The output transitions.
     * @var TransitionInterface[]
     */
    protected $outputTransitions = array();

    public function __construct(BoxInterface $box, PetriBoxFactoryInterface $petriBoxFactory)
    {
        $this->box = $box;
        $this->petri = $petriBoxFactory->getPetriBuilder();

        // create transitions associated to output points
        $this->createOutputTransitions();
        // create transitions associated to input points
        $this->createInputTransitions();
    }

    public function getBox()
    {
        return $this->box;
    }

    public function resetState()
    {
        foreach ($this->places as $name => $place) {
            $this->petri->setTokenToPlace($place, 0);
        }
    }

    public function getState()
    {
        $state = array();
        foreach ($this->places as $name => $place) {
            $state[] = array(
                self::PLACE_NAME => $name,
                self::PLACE_TOKEN => count($place));
        }
        return $state;
    }

    public function setState(array $state)
    {
        $this->resetState();
        
        foreach ($state as $p) {
            $place = $this->getPlace($p[self::PLACE_NAME]);
            $this->petri->setTokenToPlace($place, $p[self::PLACE_TOKEN]);
        }

        return $this;
    }

    public function getPetriNet()
    {
        return $this->petri->getPetrinet();
    }

    protected function addTokenToPlace($name = '')
    {
        $this->petri->addTokenToPlace($this->getPlace($name));
    }


    protected function setTokenToPlace($token, $name = '')
    {
        $this->petri->setTokenToPlace($this->getPlace($name), $token);
    }

   /**
     * Add a new place.
     * @param string $name
     * @throws \LogicException
     * @return PlaceInterface
     */
    protected function addPlace($name = '')
    {
        if (! isset($this->places[$name])) {
            $place = $this->petri->addPlace()->setBox($this->box);
            $this->places[$name] = $place;
            return $place;
        } else {
            throw new \LogicException(sprintf('A place already exists with name "%s"', $name));
        }
    }

    /**
     * Get petri place by name.
     * @param string $name
     * @return PlaceInterface|null;
     */
    protected function getPlace($name = '')
    {
        if (isset($this->places[$name])) {
            return $this->places[$name];
        }
        return null;
    }

    /**
     * Add Petri Arc between two boxes
     * @param NodeInterface $begin
     * @param NodeInterface $end
     * @return ArcInterface;
     */
    protected function addArc($begin, $end)
    {
        return $this->petri->addArc($begin, $end)->setBox($this->box);
    }

    /**
     * Adds Petri transition
     * @return transitionInterface;
     */
    protected function addTransition($name = '')
    {
        return $this->petri->addTransition()->setBox($this->box)->setName($name);
    }

    /**
     * Create inputs as Petri transition.
     * @return transitionInterface[];
     */
    protected function createInputTransitions()
    {
        foreach ($this->box->getInputPoints() as $name => $point) {
            $transition = $this->addTransition($name)->setInput($point);
            $this->inputTransitions[$name] = $transition;
        }

        return $this->inputTransitions;
    }

    public function getInputTransition($name = '')
    {
        if (isset($this->inputTransitions[$name])) {
            return $this->inputTransitions[$name];
        } else {
            throw new \LogicException(sprintf('No input transition found with name "%s"', $name));
        }
    }

    /**
     * Create outputs as Petri transition.
     * @return transitionInterface[];
     */
    protected function createOutputTransitions()
    {
        foreach ($this->box->getOutputPoints() as $name => $point) {
            $transition = $this->addTransition($name)->setOutput($point);
            $this->outputTransitions[$name] = $transition;
        }

        return $this->outputTransitions;
    }

    public function getOutputTransition($name = '')
    {
        if (isset($this->outputTransitions[$name])) {
            return $this->outputTransitions[$name];
        } else {
            throw new \LogicException(sprintf('No output transition found with name "%s"', $name));
        }
    }
}
