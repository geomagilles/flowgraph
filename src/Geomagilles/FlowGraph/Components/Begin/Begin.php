<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Begin;

use Geomagilles\FlowGraph\Factory\GraphFactoryInterface;
use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Work\LocalWork;
use Geomagilles\FlowGraph\Events\GraphEvent;
use Geomagilles\FlowGraph\Events\BoxEvent;

/**
 * Represents a begin task in a graph.
 */
class Begin extends Box implements BeginInterface
{
    public function createIO()
    {
        $this->createOutputPoint();
    }
}