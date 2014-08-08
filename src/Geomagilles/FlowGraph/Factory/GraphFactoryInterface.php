<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Factory;

use Geomagilles\FlowGraph\Point\PointInterface;

/**
 * Class for building new instances of flowchart components.
 */
interface GraphFactoryInterface
{
    /**
     * Create a new object according to its type.
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function newObject($type, $name = '');

    /**
     * Create a new object according to its type
     * Wirh Input and output points initialized
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function createObject($type, $name = '');

    /**
     * Create a new Arc.
     * @param PointInterface $beginPoint
     * @param PointInterface $endPoint
     * @param string $name
     * @return Geomagilles\FlowGraph\Arc\ArcInterface
     */
    public function createArc(PointInterface $beginPoint, PointInterface $endPoint, $name = '');

    /**
     * Create a new InputPoint.
     * @param string $name
     * @return Geomagilles\FlowGraph\Point\InputPoint\InputPointInterface
     */
    public function createInputPoint($name = '');

    /**
     * Create a new OutputPoint.
     * @param string $name
     * @return Geomagilles\FlowGraph\Point\OutputPoint\OutputPointInterface
     */
    public function createOutputPoint($name = '');

        /**
     * Create a new TriggerPoint.
     * @param string $name
     * @return Geomagilles\FlowGraph\Point\TriggerPoint\TriggerPointInterface
     */
    public function createTriggerPoint($name = '');

    /**
     * Create a new Graph.
     * @param string $name
     * @return Geomagilles\FlowGraph\GraphInterface
     */
    public function createGraph($name = '');

    /**
     * Create a new Begin box.
     * @param string $name
     * @return Geomagilles\FlowGraph\Components\Begin\BeginInterface
     */
    public function createBegin($name = '');

    /**
     * Create a new End box.
     * @param string $name
     * @return Geomagilles\FlowGraph\Components\End\EndInterface
     */
    public function createEnd($name = '');

    /**
     * Create a new Task box.
     * @param string $name
     * @return Geomagilles\FlowGraph\Components\Task\TaskInterface
     */
    public function createTask($name = '');

    /**
     * Create a new Wait box.
     * @param string $name
     * @return Geomagilles\FlowGraph\Components\Wait\WaitInterface
     */
    public function createWait($name = '');

    /**
     * Create a new Synchronizer box.
     * @param string $name
     * @return Geomagilles\FlowGraph\Components\Synchronizer\SynchronizerInterface
     */
    public function createSynchronizer($name = '');
}
