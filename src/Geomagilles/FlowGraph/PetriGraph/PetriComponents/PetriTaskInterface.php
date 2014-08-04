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
 * Represents a petri box.
 */
interface PetriTaskInterface extends PetriBoxInterface
{
    /**
     * Fire trigger by name
     * @param string $name
     */
    public function fireTrigger($name);
}
