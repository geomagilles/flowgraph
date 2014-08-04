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
    public function addGraph($name);

    /**
     * Add a synchronize to this graph
     * @return SynchronizerInterface
     */
    public function addSynchronizer();

    /**
     * Add a job to this graph
     * @param string $def
     * @param array $cases
     * @return JobInterface
     */
    public function addTask($job, $cases = array());

    /**
     * Add a Begin to this graph
     * @return BeginInterface
     */
    public function addBegin();

    /**
     * Add an End to this graph
     * @return EndInterface
     */
    public function addEnd();

    /**
     * Add an arc to this graph
     * @param BoxInterface $begin
     * @param BoxInterface $end
     * @param string $outputName
     * @param string $inputName
     * @return ArcInterface
     */
    public function addArc(BoxInterface $begin, BoxInterface $end, $outputName = '', $inputName = '');

    /**
     * Add an input point from a subjascent box
     * @param PointInterface $point
     * @param string $name
     * @return PointInterface
     */
    public function addInputPoint(PointInterface $point, $name = '');

    /**
     * Add an output point from a subjascent box
     * @param PointInterface $point
     * @param string $name
     * @return PointInterface
     */
    public function addOutputPoint(PointInterface $point, $name = '');
}
