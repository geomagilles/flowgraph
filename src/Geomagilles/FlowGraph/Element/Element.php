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

abstract class Element implements ElementInterface
{
    /**
     * The settings of this element.
     *
     * @var string
     */
    protected $settings;

    /**
     * The element identifier.
     * @var mixed $id
     */
    protected $id;

    /**
     * The element name.
     * @var string $name
     */
    protected $name;

    /**
     * The event Dispatcher 
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * The graph factory.
     * @var GraphFactoryInterface $factory
     */
    protected $factory;

    /**
     * Create a new element
     * @var string $name
     */
    public function __construct(GraphFactoryInterface $factory, $name = '')
    {
        $this->factory = $factory;
        $this->setName($name);
    }

    public function getEventDispatcher()
    {
        return $this->factory->getEventDispatcher();
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    public function getSettings()
    {
        return $this->settings;
    }
}
