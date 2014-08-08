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

use Geomagilles\FlowGraph\Components\Wait\WaitInterface;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;

class PetriWait extends PetriTask implements PetriWaitInterface
{
    /**
     * The trigger transitions.
     * @var TransitionInterface[]
     */
    protected $triggerTransitions = array();

    public function __construct(WaitInterface $wait, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($wait, $petriBoxFactory);

        // create transitions associated to trigger points
        $this->createTriggerTransitions();

        // places
        $before = $this->getPlace(self::PLACE_BEFORE);
        $after  = $this->getPlace(self::PLACE_AFTER);
        $idle   = $this->getPlace(self::PLACE_IDLE);

        foreach ($wait->getTriggerPoints() as $name => $point) {

            $transition = $this->getTriggerTransition($name);
            $this->addArc($after, $transition);

            $place = $this->addTriggerPlace($name);
            $this->addArc($place, $transition);

            $settings = $point->getSettings();
            if ($settings[WaitInterface::TRIGGER_TRANSIENT]) {
                $transiant = $this->addTransition();
                $this->addArc($place, $transiant);
                $this->addArc($transiant, $idle);
                $this->addArc($idle, $transiant);
            } else {
                $this->addArc($transition, $place);
            }
        }
    }

    public function fireTrigger($name)
    {
        $place = $this->getTriggerPlace($name);

        $this->petri->addTokenToPlace($place);
    }

    public function getTriggerTransition($name = '')
    {
        if (isset($this->triggerTransitions[$name])) {
            return $this->triggerTransitions[$name];
        } else {
            throw new \LogicException(sprintf('No trigger transition found with name "%s"', $name));
        }
    }

    /**
     * Find trigger place by name.
     * @param string $name
     * @return placeInterface;
     */
    protected function getTriggerPlace($name = '')
    {
        $place = $this->getPlace($name);

        if ($place->isTrigger()) {
            return $place;
        } else {
            throw new \LogicException(
                sprintf(
                    'No trigger place "%s" found in box "%s"',
                    $name,
                    $this->box->getName()
                )
            );
        }
    }

    /**
     * Create triggers as Petri transition.
     * @return transitionInterface[];
     */
    protected function createTriggerTransitions()
    {
        foreach ($this->box->getTriggerPoints() as $name => $point) {
            $transition = $this->addTransition($name)->setTrigger($point);
            $this->triggerTransitions[$name] = $transition;
        }

        return $this->triggerTransitions;
    }

    /**
     * Create a place used as a trigger
     * $param string $name
     * @return placeInterface;
     */
    protected function addTriggerPlace($name = '')
    {
        return $this->addPlace($name)->setTrigger();
    }
}
