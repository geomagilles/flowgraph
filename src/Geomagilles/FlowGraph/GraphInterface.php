<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Arc\ArcInterface;

/**
 * Interface for graphs.
 */
interface GraphInterface extends BoxInterface
{
    /**
     * Add a box to this graph
     * @param BoxInterface $box
     * @return BoxInterface
     */
    public function addBox(BoxInterface $box);

    /**
     * Get all boxes of this graph
     * @return BoxInterface[]
     */
    public function getBoxes();

    /**
     * Recursivaly get a box by its id
     * @param mixed $id
     * @return BoxInterface|null
     */
    public function getBoxById($id);

    /**
     * Get a box of this graph by name
     * @param string $name
     * @return BoxInterface
     */
    public function getBox($name);

    /**
     * Add an arc in this graph.
     * @param ArcInterface $arc
     * @return ArcInterface
    */
    public function addArc(ArcInterface $arc);
 
    /**
     * Get all arcs of this graph
     * @return ArcInterface[]
     */
    public function getArcs();
}
