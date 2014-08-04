<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Element;

use Geomagilles\FlowGraph\Factory\GraphFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Represents a Digraph arc.
 */
interface ElementInterface
{
    /**
     * Get the event dispatcher.
     * @return EventDispatcherInterface 
     */
    public function getEventDispatcher();

    /**
     * Get the factory.
     * @return GraphFactoryInterface 
     */
    public function getFactory();

    /**
     * Set the element identifier.
     * @param mixed $id
     */
    public function setId($id);

    /**
     * Get the element identifier.
     * @return mixed 
     */
    public function getId();

    /**
     * Set the element name.
     * @param string $name
     */
    public function setName($name);

    /**
     * Get the element name.
     * @return string 
     */
    public function getName();

    /**
     * Set the element settings.
     * @param string $settings
     */
    public function setSettings($settings);

    /**
     * Get the element settings.
     * @return string 
     */
    public function getSettings();
}
