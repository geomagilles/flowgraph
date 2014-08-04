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

use Geomagilles\FlowGraph\Components\Synchronizer\SynchronizerInterface;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBox;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

class PetriSynchronizer extends PetriBox implements PetriBoxInterface
{
    /**
     * Name of place after work
     * @var string
     */
    const PLACE_AFTER = 'after';

    public function __construct(SynchronizerInterface $synchronizer, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($synchronizer, $petriBoxFactory);

        // output transition
        $output = $this->getOutputTransition();

        // wire each input branch
        foreach ($synchronizer->getInputPoints() as $name => $point) {
            $place = $this->addPlace($name);
            $this->addArc($this->getInputTransition($name), $place);
            $this->addArc($place, $output);
        }

        // reset state
        $this->resetState();
    }
}
