<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Engine;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Geomagilles\FlowGraph\PetriGraph\PetriBox\PetriBoxInterface;

interface EngineInterface
{
    public function getPetriGraph();
    
    public function resetState();

    public function setState($state);

    public function getState();

    public function setData($data);

    public function getData();

    public function run();
}
