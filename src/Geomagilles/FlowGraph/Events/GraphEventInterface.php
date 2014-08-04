<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Events;

use Geomagilles\FlowGraph\GraphInterface;

interface GraphEventInterface
{
    /**
     * Get graph
     * @return GraphInterface
     */
    public function getGraph();

    /**
     * Get state
     * @return mixed
     */
    public function getState();

    /**
     * Get data
     * @return mixed
     */
    public function getData();
}
