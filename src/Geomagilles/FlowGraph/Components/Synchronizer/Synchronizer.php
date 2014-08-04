<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Components\Synchronizer;

use Geomagilles\FlowGraph\Box\Box;
use Geomagilles\FlowGraph\Factory\GraphFactoryInterface;

/**
 * Represents a synchronizer task in a graph.
 */
class Synchronizer extends Box implements SynchronizerInterface
{
    public function createIO()
    {
        $this->createOutputPoint();
    }
}
