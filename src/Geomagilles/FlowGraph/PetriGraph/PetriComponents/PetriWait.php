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

use Geomagilles\FlowGraph\Exceptions\TriggerNotFoundException;
use Geomagilles\FlowGraph\Components\Wait\WaitInterface;
use Geomagilles\FlowGraph\PetriGraph\factory\PetriBoxFactoryInterface;

class PetriWait extends PetriTask implements PetriWaitInterface
{
    public function __construct(WaitInterface $wait, PetriBoxFactoryInterface $petriBoxFactory)
    {
        parent::__construct($wait, $petriBoxFactory);
    }
}
