<?php

/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\PetriNet\Transition;

use Geomagilles\FlowGraph\Work\WorkInterface;
use Geomagilles\FlowGraph\Box\BoxInterface;
use Geomagilles\FlowGraph\Points\PointInterface;

interface TransitionInterface extends \Petrinet\Transition\TransitionInterface
{
    public function isInput();

    public function getInput();

    public function setInput(PointInterface $input);

    public function isOutput();

    public function getOutput();

    public function setOutput(PointInterface $output);

    public function hasJob();

    public function getJob();

    public function setJob($job);

    public function getBox();

    public function setBox(BoxInterface $box);

    public function getName();

    public function setName($name);
}
