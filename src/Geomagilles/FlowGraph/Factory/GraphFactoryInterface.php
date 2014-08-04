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

use Geomagilles\FlowGraph\Arc\ArcInterface;
use Geomagilles\FlowGraph\Point\PointInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\GraphInterface;

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
     * @return ArcInterface
     */
    public function createArc(PointInterface $beginPoint, PointInterface $endPoint, $name = '');

    /**
     * Create a new Point.
     * @param string $name
     * @return PointInterface
     */
    public function createPoint($name = '');

    /**
     * Create a new Graph.
     * @param string $name
     * @param boolean $build
     * @return GraphInterface
     */
    public function createGraph($name = '');

    /**
     * Create a new Begin box.
     * @param string $name
     * @param boolean $build
     * @return BeginInterface
     */
    public function createBegin($name = '');

    /**
     * Create a new End box.
     * @param string $name
     * @param boolean $build
     * @return EndInterface
     */
    public function createEnd($name = '');

    /**
     * Create a new Task box.
     * @param string $name
     * @param boolean $build
     * @return DecisionInterface
     */
    public function createTask($name = '');

    /**
     * Create a new Synchronizer box.
     * @param string $name
     * @param boolean $build
     * @return SynchronizerInterface
     */
    public function createSynchronizer($name = '');
}
