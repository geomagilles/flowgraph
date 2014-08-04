<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\Dumper;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\PetriNet\PetriNetInterface;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactory;
use Geomagilles\FlowGraph\PetriGraph\Factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

/**
 * Dumps a Petrinet in Graphviz format.
 */
class GraphDumper implements DumperInterface
{

    public function __construct(PetriBoxFactoryInterface $petriBoxFactory = null)
    {
        $this->petriBoxFactory = is_null($petriBoxFactory) ? new PetriBoxFactory() : $petriBoxFactory;
    }

    private function getName($object)
    {
        return str_replace('\\', '\\\\', $object->getName());
    }

    private function getLabel(BoxInterface $box)
    {
        if ($box->hasJob()) {
            return str_replace('\\', '\\\\', $box->getJob());
        }
        return str_replace('\\', '\\\\', get_class($box));
    }
    
    private function getId($object)
    {
        if (! is_null($object->getId())) {
            return $object->getId();
        } else {
            return 'id_'.spl_object_hash($object);
        }
    }

    private function getIdLabel($object)
    {
        return is_null($object->getId()) ? 'NULL' : (string) $object->getId();
    }

    private function dumpSubgraph(&$text, BoxInterface $box, PetriNetInterface $petrinet)
    {
        $text .= "\n";
        $text .= 'subgraph cluster_'.$this->getId($box).' {'."\n";
        $text .= '  label = "' . $this->getLabel($box).' (id='.$this->getIdLabel($box). ')";'."\n";
        $text .= '  style = filled;'."\n";
        $text .= '  color = lightgrey;'."\n";
        $text .= '  node [style=filled,color=white];'."\n";
        foreach ($petrinet->getArcs() as $arc) {
            $input = $arc->getFrom();
            $output = $arc->getTo();
            if (($input->getBox() == $output->getBox()) &&
                ($input->getBox() == $box)) {
                $text .= '  ' . $this->getId($input) . '->' . $this->getId($output) . ';'."\n";
            }
        }
        $text .= '}'."\n";
    }

    public function dump(PetriBoxInterface $petriBox)
    {
        $box = $petriBox->getBox();
        $petrinet = $petriBox->getPetrinet();
        $text = 'digraph ' . $this->getId($box) . " {\n";

        if ($box->isGraph()) {
            foreach ($box->getBoxes() as $b) {
                $this->dumpSubgraph($text, $b, $petrinet);
            }
        } else {
            $this->dumpSubgraph($text, $box, $petrinet);
        }

        // places
        foreach ($petrinet->getPlaces() as $place) {
            $text .= $this->getId($place);
            $text .= ' [label="' . count($place) . '",shape="circle"];'."\n";
        }

        // transition
        foreach ($petrinet->getTransitions() as $transition) {
            $text .= $this->getId($transition);
            $text .=' [label="'. $this->getName($transition) .'",';
            if ($transition->hasJob()) {
                $text .='shape=box];'."\n";
            } elseif ($transition->isInput()) {
                $text .='shape=square, fontsize=10];'."\n";
            } elseif ($transition->isOutput()) {
                $text .='shape=square, fontsize=10];'."\n";
            } else {
                $text .='shape=box];'."\n";
            }
        }

        // arcs
        foreach ($petrinet->getArcs() as $arc) {
            $input = $arc->getFrom();
            $output = $arc->getTo();
            if ($input->getBox() != $output->getBox()) {
                $text .= $input->getId() . '->' . $output->getId() . ';'."\n";
            }
        }
        $text .= "}";

        return $text;
    }
}
