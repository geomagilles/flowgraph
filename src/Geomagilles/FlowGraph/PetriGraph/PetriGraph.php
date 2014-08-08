<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriGraph;

use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\GraphInterface;

class PetriGraph extends PetriBox implements PetriGraphInterface
{
    const PLACE_POINT   = 'point';

    /**
     * The list of Petri Boxes
     * @var PetriBox[]
     */
    private $petriBoxes = array();

    public function __construct(GraphInterface $graph, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($graph, $petriBoxFactory);

        // add boxes
        foreach ($graph->getBoxes() as $name => $box) {
            $petriBox = $petriBoxFactory->create($box);
            $this->petriBoxes[$name] = $petriBox;
            // add place and arc for each input points
            foreach ($box->getInputPoints() as $name => $input) {
                $transition = $petriBox->getInputTransition($name);
                $place = $this->petri->addPlace()->setBox($graph);
                $this->petri->addArc($place, $transition);
                // memorize this Petri place
                $this->places[$box->getName()][$name] = $place;
            }
        }
        
        // add arcs
        foreach ($graph->getArcs() as $arc) {
            // get begin box
            $output = $arc->getBeginPoint();
            $begin = $output->getBox();
            // get end box
            $input = $arc->getEndPoint();
            $end = $input->getBox();
            // add Petri arc
            if ($output->isOutput()) {
                $transition = $this->petriBoxes[$begin->getName()]->getOutputTransition($output->getName());
            } elseif ($output->isTrigger()) {
                $transition = $this->petriBoxes[$begin->getName()]->getTriggerTransition($output->getName());
            }
            $place = $this->places[$end->getName()][$input->getName()];
            $this->petri->addArc($transition, $place)->setBox($graph);
        }

        // reset state
        $this->resetState();
    }

    public function resetState()
    {
        foreach ($this->petriBoxes as $name => $petriBox) {
            $petriBox->resetState();
        }

        foreach ($this->places as $boxInputs) {
            foreach ($boxInputs as $name => $place) {
                $this->petri->setTokenToPlace($place, 0);
            }
        }
    }

    public function getState()
    {
        $state = array();
        foreach ($this->petriBoxes as $name => $petriBox) {
            $state[] = array(
                self::BOX_NAME => $name,
                self::BOX_STATE => $petriBox->getState()
            );
        }
        foreach ($this->places as $name => $place) {
            foreach ($place as $inputName => $place) {
                $a = array();
                $a[self::PLACE_NAME] = $name;
                $a[self::PLACE_POINT] = $inputName;
                $a[self::PLACE_TOKEN] = count($place);
                $state[] = $a;
            }
        }
        return $state;
    }

    public function setState(array $state)
    {
        foreach ($state as $element) {
            if (isset($element[self::PLACE_NAME])) {
                // add places with tokens
                $place = $this->getGraphPlace($element[self::PLACE_NAME], $element[self::PLACE_POINT]);
                $this->petri->setTokenToPlace($place, $element[self::PLACE_TOKEN]);
            } elseif (isset($element[self::BOX_NAME])) {
                // recursively set state of PetriBox
                $PetriBox = $this->getPetriBox($element[self::BOX_NAME]);
                $PetriBox->setState($element[self::BOX_STATE]);
            } else {
                throw new \Exception('Blame me - this should not happen');
            }
        }
    }

    public function getPetriBoxById($id)
    {
        foreach ($this->petriBoxes as $name => $petriBox) {
            if ($petriBox->getBox()->isGraph()) {
                $found = $petriBox->getPetriBoxById($id);
                if (! is_null($found)) {
                    return $found;
                }
            } elseif ($petriBox->getBox()->getId() === $id) {
                return $petriBox;
            }
        }
        return null;
    }

    /**
    * Gets a place by box & point.
    * @param string $name
    * @param string $pointName
    * @return placeInterface
    */
    protected function getGraphPlace($name, $pointName = '')
    {
        if (isset($this->places[$name][$pointName])) {
            return $this->places[$name][$pointName];
        }
        return null;
    }

    /**
    * Gets a petri box by name.
    * @param string $name
    * @return PetriBoxInterface
    */
    private function getPetriBox($name)
    {
        if (isset($this->petriBoxes[$name])) {
            return $this->petriBoxes[$name];
        }
        return null;
    }
}
