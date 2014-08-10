<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph\PetriComponents;

use Geomagilles\FlowGraph\Components\Task\TaskInterface;
use Geomagilles\FlowGraph\Exceptions\OutputNotFoundException;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

class PetriTask extends PetriBox implements PetriBoxInterface
{
   /**
     * The job transition
     * @var TransitionInterface
     */
    protected $jobTransition;

    /**
     * The name of 'before' place
     * @var string
     */
    const PLACE_BEFORE = 'before';

    /**
     * The name of 'after' place
     * @var string
     */
    const PLACE_AFTER = 'after';

    /**
     * The name of 'idle' place
     * @var string
     */
    const PLACE_IDLE = 'idle';

    /**
     * The name of 'retry' place
     * @var string
     */
    const PLACE_RETRY = '_retry';

    public function __construct(TaskInterface $task, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($task, $petriBoxFactory);

        // job transition
        $work  = $this->createJobTransition();

        // input transition
        $input = $this->getInputTransition();

        // places
        $before = $this->addPlace(self::PLACE_BEFORE);
        $after  = $this->addPlace(self::PLACE_AFTER);
        $idle   = $this->addPlace(self::PLACE_IDLE);

        // arcs
        $this->addArc($idle, $input);
        $this->addArc($input, $before);
        $this->addArc($before, $work);
        $this->addArc($work, $after);

        foreach ($task->getOutputPoints() as $name => $point) {

            $transition = $this->getOutputTransition($name);
            $this->addArc($after, $transition);

            $place = $this->addOutputPlace($name);
            $this->addArc($place, $transition);

            if ($name == TaskInterface::OUTPUT_RETRY) {
                $this->addArc($transition, $before);
            } else {
                $this->addArc($transition, $idle);
            }
        }

        // reset state
        $this->resetState();
    }


    public function resetState()
    {
        // reset all tokens
        parent::resetState();

        // add a token to idle place
        $this->addTokenToPlace(self::PLACE_IDLE);
    }

    public function fireOutput($name)
    {
        $place = $this->getOutputPlace($name);

        $this->petri->addTokenToPlace($place);
    }

    /**
     * Get output place by name.
     * @param string $name
     * @return placeInterface;
     */
    protected function getOutputPlace($name = '')
    {
        $place = $this->getPlace($name);

        if ((! is_null($place)) && $place->isOutput()) {
            return $place;
        } else {
            throw new OutputNotFoundException(
                sprintf(
                    'No output place "%s" found in box "%s"',
                    $name,
                    $this->box->getName()
                )
            );
        }
    }

    /**
     * Create a place used as an output
     * $param string $name
     * @return placeInterface;
     */
    protected function addOutputPlace($name = '')
    {
        return $this->addPlace($name)->setOutput();
    }

    /**
     * Get job Petri transition
     * @return transitionInterface;
     */
    protected function getJobTransition()
    {
        return $this->jobTransition;
    }

    /**
     * Create job as Petri transition.
     * @return transitionInterface;
     */
    protected function createJobTransition()
    {
        $this->jobTransition = $this->addTransition();
        
        if ($this->box->hasJob()) {
            $this->jobTransition->setJob($this->box->getJob());
        }

        return $this->jobTransition;
    }
}
