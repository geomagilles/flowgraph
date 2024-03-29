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

use Symfony\Component\EventDispatcher\Event;
use Geomagilles\FlowGraph\GraphInterface;

class GraphEvent extends Event implements GraphEventInterface
{
    const ENGINE_START = 'Geomagilles\FlowGraph.GraphEvent.ENGINE_START';

    const ENGINE_STOP = 'Geomagilles\FlowGraph.GraphEvent.ENGINE_STOP';
    
    const BEGIN_REACH = 'Geomagilles\FlowGraph.GraphEvent.BEGIN_REACH';
    
    const END_REACH   = 'Geomagilles\FlowGraph.GraphEvent.END_REACH';

    const BEFORE_BOX = 'Geomagilles\FlowGraph.GraphEvent.BEFORE_BOX';

    const AFTER_BOX = 'Geomagilles\FlowGraph.GraphEvent.AFTER_BOX';

    /**
     * The graph.
     */
    protected $graph;

    /**
     * The state.
     */
    protected $state;

    /**
     * The data.
     */
    protected $data;

    /**
     * Creates a new GraphEvent event.
     *
     * @param GraphInterface $graph
     * @param $state
     * @param $data
     */
    public function __construct(GraphInterface $graph, $state, $data)
    {
        $this->graph = $graph;
        $this->state = $state;
        $this->data = $data;
    }

    public function getGraph()
    {
        return $this->graph;
    }
    
    public function getState()
    {
        return $this->state;
    }

    public function getData()
    {
        return $this->data;
    }
}
