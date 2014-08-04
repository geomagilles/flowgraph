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

use Geomagilles\FlowGraph\GraphInterface;

/**
 * Interface for graph dumpers.
 */
interface GraphDumperInterface
{
    /**
     * Dumps a graph.
     *
     * @param GraphInterface $graph
     *
     * @return string
     */
    public function dump(GraphInterface $graph);
}
