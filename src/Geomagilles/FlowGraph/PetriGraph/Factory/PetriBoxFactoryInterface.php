<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\Factory;

use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;
use Geomagilles\FlowGraph\PetriGraph\Begin\PetriBeginInterface;
use Geomagilles\FlowGraph\PetriGraph\End\PetriEndInterface;
use Geomagilles\FlowGraph\PetriGraph\Synchronizer\PetriSynchronizerInterface;
use Geomagilles\FlowGraph\PetriGraph\Task\PetriTaskInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\Components\Begin\BeginInterface;
use Geomagilles\FlowGraph\Components\End\EndInterface;
use Geomagilles\FlowGraph\Components\Synchronizer\SynchronizerInterface;
use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\PetriNet\Builder\PetriBuilderInterface;

/**
 * Interface for PetriBox factory.
 */
interface PetriBoxFactoryInterface
{
    /**
     * Get Petri builder for this factory
     * @return PetriBuilderInterface
     */
    public function getPetriBuilder();

    /**
     * Create a new petri box
     * @return PetriBoxInterface
     */
    public function create(BoxInterface $box);

    /**
     * Create a new petri graph
     * @return PetriBoxInterface
     */
    public function createPetriGraph(GraphInterface $graph);

    /**
     * Create a new petri begin
     * @return PetriBeginInterface
     */
    public function createPetriBegin(BeginInterface $begin);

    /**
     * Create a new petri end
     * @return PetriEndInterface
     */
    public function createPetriEnd(EndInterface $end);

    /**
     * Create a new petri task box
     * @return PetriTaskInterface
     */
    public function createPetriTask(TaskInterface $task);
    
    /**
     * Create a new petri synchronizer
     * @return PetriSynchronizerInterface
     */
    public function createPetriSynchronizer(SynchronizerInterface $synchronizer);
}
