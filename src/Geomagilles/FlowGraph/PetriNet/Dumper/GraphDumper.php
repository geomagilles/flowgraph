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
 * Dumps a Petrinet in Graphviz format.
 */
class GraphDumper implements DumperInterface
{

    private function fixLabel($name)
    {
        return str_replace('\\', '\\\\', $name);
    }

    public function dump(PetriNetInterface $petrinet)
    {
        $text = 'digraph ' . $petrinet->getId() . " {\n";

        foreach ($petrinet->getPlaces() as $place) {
            $tokens = count($place);
            $text .= $place->getId() . ' [label="' . $place->getId() . ': ' . $tokens;
            $tokens > 1 ? $text .= ' tokens"];' : $text .= ' token"];';
            $text .= "\n";
        }

        foreach ($petrinet->getTransitions() as $transition) {
            $text .= $transition->getId() . " [shape=box];\n";
        }

        foreach ($petrinet->getArcs() as $arc) {
            $input = $arc->getFrom();
            $output = $arc->getTo();
            $text .= $input->getId() . '->' . $output->getId() . ";\n";
        }

        $text .= "}";

        return $text;
    }
}
