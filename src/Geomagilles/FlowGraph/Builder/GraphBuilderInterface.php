<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Builder;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\Components\Synchronizer\SynchronizerInterface;
use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\Components\Begin\BeginInterface;
use Geomagilles\FlowGraph\Components\End\EndInterface;
use Geomagilles\FlowGraph\Arc\ArcInterface;
use Geomagilles\FlowGraph\Point\PointInterface;

/**
 * Interface for graphs.
 */
interface GraphBuilderInterface
{
    /**
     * Get Graph
     * @return GraphInterface
     */
    public function getGraph();

    /**
     * Add a graph to this graph
     * @param string $name
     * @return GraphInterface
     */
    public function graph($name);

    /**
     * Add a synchronize to this graph
     * @return SynchronizerInterface
     */
    public function synchronizer();

    /**
     * Add a job to this graph
     * @param string $def
     * @return JobInterface
     */
    public function task($job);

    /**
     * Add a Begin to this graph
     * @return BeginInterface
     */
    public function begin();

    /**
     * Add an End to this graph
     * @return EndInterface
     */
    public function end();

    /**
     * Connect two boxes by an arc
     * @param array|BoxInterface $begin
     * @param array|BoxInterface $end
     * @return self
     */
    public function connect($begin, $end);
}
