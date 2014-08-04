<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph;

use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

/**
 * Represents a petri box.
 */
interface PetriGraphInterface extends PetriBoxInterface
{
    /**
     * Recursively get a petriBox by id
     * @param mixed $id
     * @return PetriBoxInterface|null
     */
    public function getPetriBoxById($id);
}
