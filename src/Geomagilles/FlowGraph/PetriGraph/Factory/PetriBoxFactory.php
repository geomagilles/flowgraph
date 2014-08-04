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

use Geomagilles\FlowGraph\PetriNet\Builder\PetriBuilderInterface;
use Geomagilles\FlowGraph\PetriNet\Builder\PetriBuilder;

use Geomagilles\FlowGraph\PetriGraph\PetriGraph;
use Geomagilles\FlowGraph\PetriGraph\PetriComponents\PetriBegin;
use Geomagilles\FlowGraph\PetriGraph\PetriComponents\PetriEnd;
use Geomagilles\FlowGraph\PetriGraph\PetriComponents\PetriTask;
use Geomagilles\FlowGraph\PetriGraph\PetriComponents\PetriSynchronizer;

use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\GraphInterface;
use Geomagilles\FlowGraph\Components\Begin\BeginInterface;
use Geomagilles\FlowGraph\Components\End\EndInterface;
use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\Components\Synchronizer\SynchronizerInterface;

class PetriBoxFactory implements PetriBoxFactoryInterface
{
    /**
     * The petri builder
     * @var PetriBuilderInterface
     */
    protected $petri;

    public function __construct(PetriBuilderInterface $petri = null)
    {
        $this->petri = is_null($petri) ? new PetriBuilder() : $petri;
    }

    public function getPetriBuilder()
    {
        return $this->petri;
    }

    public function create(BoxInterface $box)
    {
        $f = $box->getFactory();

        if ($f->isGraph($box)) {
            return $this->createPetriGraph($box);
        } elseif ($f->isBegin($box)) {
            return $this->createPetriBegin($box);
        } elseif ($f->isEnd($box)) {
            return $this->createPetriEnd($box);
        } elseif ($f->isTask($box)) {
            return $this->createPetriTask($box);
        } elseif ($f->isSynchronizer($box)) {
            return $this->createPetriSynchronizer($box);
        }

        throw new \InvalidArgumentException(
            sprintf(
                'No known PetriBox for box "%s" of type "%s"',
                $box->getName(),
                $f->getType($box)
            )
        );
    }

    public function createPetriGraph(GraphInterface $graph)
    {
        return new PetriGraph($graph, $this);
    }

    public function createPetriBegin(BeginInterface $begin)
    {
        return new PetriBegin($begin, $this);
    }

    public function createPetriEnd(EndInterface $end)
    {
        return new PetriEnd($end, $this);
    }

    public function createPetriTask(TaskInterface $task)
    {
        return new PetriTask($task, $this);
    }

    public function createPetriSynchronizer(SynchronizerInterface $synchronizer)
    {
        return new PetriSynchronizer($synchronizer, $this);
    }
}
