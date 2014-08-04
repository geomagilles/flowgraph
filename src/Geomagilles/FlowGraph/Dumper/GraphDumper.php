<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Dumper;

use Geomagilles\FlowGraph;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\GraphInterface;

/**
 * Dumps a graph in Graphviz format.
 */
class GraphDumper implements GraphDumperInterface
{

    private function getName($object, $default = '')
    {
        $name = ($object->getName() == '') ? $default : $object->getName();
        return str_replace('\\', '\\\\', $name);
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

    public function dump(GraphInterface $graph)
    {
        $text = 'digraph "' . $this->getId($graph) . '" {'."\n";

        foreach ($graph->getBoxes() as $box) {
            $text .= "\n";
            $text .= 'subgraph cluster_'.$this->getId($box).' {'."\n";
            $text .= '  label = "' . $this->getLabel($box).' (id='.$this->getIdLabel($box). ')";'."\n";
            $text .= '  style = filled;'."\n";
            $text .= '  color = lightgrey;'."\n";
            $text .= '  node [style=filled,color=white];'."\n";
            foreach ($box->getInputPoints() as $point) {
                $text .= '  ' . $this->getId($point);
                $text .= ' [label="' . $this->getName($point, 'In') . '",shape="square"];'."\n";

            }
            foreach ($box->getOutputPoints() as $point) {
                $text .= '  ' . $this->getId($point);
                $text .= ' [label="' . $this->getName($point, 'Out') . '",shape="square"];'."\n";
            }
            $text .= '}'."\n";
        }

        foreach ($graph->getArcs() as $arc) {
            $input = $arc->getBeginPoint();
            $output = $arc->getEndPoint();
            $text .= '"' . $this->getId($input) . '"->"' . $this->getId($output) . '";'."\n";
        }

        $text .= "}";

        return $text;
    }
}
