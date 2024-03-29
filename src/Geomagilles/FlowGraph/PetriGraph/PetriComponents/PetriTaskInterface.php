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

use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

/**
 * Represents a petri task.
 */
interface PetriTaskInterface extends PetriBoxInterface
{
    /**
     * Fire an output
     * @param string $name 
     */
    public function fireOutput($name);
}
