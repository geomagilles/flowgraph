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

/**
 * Represents a petri box.
 */
interface PetriBoxInterface
{
    /**
     * Get the Petrinet
     * This can include other components than this box
     * @return PetriNetInterface;
     */
    public function getPetriNet();

    /**
     * Get this petri box state
     * @return array;
     */
    public function getState();

    /**
     * Set this petri box state
     * @param array $state
     * @return self;
     */
    public function setState(array $state);

    /**
     * Get input Petri transition by name
     * @param string $name
     * @throws \LogicException
     * @return transitionInterface;
     */
    public function getInputTransition($name = '');

    /**
     * Get output Petri transition by name
     * @param string $name
     * @throws \LogicException
     * @return transitionInterface;
     */
    public function getOutputTransition($name = '');
}
