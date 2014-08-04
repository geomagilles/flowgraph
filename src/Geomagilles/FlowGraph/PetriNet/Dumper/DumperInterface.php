<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Dumper;

use Geomagilles\FlowGraph\PetriNet\PetriNetInterface;

/**
 * Interface for Petrinet dumpers.
 */
interface DumperInterface
{
    /**
     * Dump a box.
     * @param PetriNetInterface $petrinet
     * @return string The string representation
     */
    public function dump(PetriNetInterface $petrinet);
}
