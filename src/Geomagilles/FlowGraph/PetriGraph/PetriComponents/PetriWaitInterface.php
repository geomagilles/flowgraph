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

/**
 * Represents a petri task.
 */
interface PetriWaitInterface extends PetriTaskInterface
{
    /**
     * Fire a trigger
     * @param string $name 
     */
    public function fireTrigger($name);

    /**
     * Get trigger Petri transition by name
     * @param string $name
     * @throws \LogicException
     * @return transitionInterface;
     */
    public function getTriggerTransition($name = '');
}
