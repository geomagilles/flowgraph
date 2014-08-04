<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Graph\Box;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Box\Box;

/**
 * Test class for Point.
 */
class BoxTest extends BaseTest
{
    const TESTED_CLASS = 'Geomagilles\FlowGraph\Box\Box';

    public function testConstructor()
    {
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS);
        $this->assertInstanceOf('Geomagilles\FlowGraph\Element\ElementInterface', $box);
        $this->assertEquals('', $box->getName());
        $this->assertInstanceOf('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface', $box->getFactory());
    }

    public function testConstructorWithNameAndFactory()
    {
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('myName', $factory));
        $this->assertSame('myName', $box->getName());
        $this->assertSame($factory, $box->getFactory());
    }

    public function testInputPoint()
    {
        $point1 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('second'));

        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        
        $this->assertFalse($box->hasAnyInputPoint());
        $this->assertCount(0, $box->getInputPoints());
        
        $this->invokeMethod($box, 'addInputPoint', array($point1));
        $this->assertTrue($box->hasAnyInputPoint());
        $this->assertSame($point1, $box->getInputPoint());
        $this->assertCount(1, $box->getInputPoints());

        $this->invokeMethod($box, 'addInputPoint', array($point2));
        $this->assertTrue($box->hasAnyInputPoint());
        $this->assertSame($point2, $box->getInputPoint('second'));
        $this->assertCount(2, $box->getInputPoints());
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddInputPointWithSameName()
    {
        $point1 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'addInputPoint', array($point1));
        $this->invokeMethod($box, 'addInputPoint', array($point2));
    }

    public function testOutputPoint()
    {
        $point1 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('second'));

        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));

        $this->assertFalse($box->hasAnyOutputPoint());
        $this->assertCount(0, $box->getOutputPoints());
        
        $this->invokeMethod($box, 'addOutputPoint', array($point1));
        $this->assertTrue($box->hasAnyOutputPoint());
        $this->assertSame($point1, $box->getOutputPoint());
        $this->assertCount(1, $box->getOutputPoints());

        $this->invokeMethod($box, 'addOutputPoint', array($point2));
        $this->assertTrue($box->hasAnyOutputPoint());
        $this->assertSame($point2, $box->getOutputPoint('second'));
        $this->assertCount(2, $box->getOutputPoints());
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddOutputPointWithSameName()
    {
        $point1 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $point2 = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'addOutputPoint', array($point1));
        $this->invokeMethod($box, 'addOutputPoint', array($point2));
    }

    public function testSetGetGraph()
    {
        $graph = $this->getMock('Geomagilles\FlowGraph\Components\Graph\GraphInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->assertSame(null, $box->getGraph());
        $this->invokeMethod($box, 'setGraph', array($graph));
        $this->assertSame($graph, $box->getGraph());
    }

    public function testIsGraph()
    {
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->assertFalse($this->invokeMethod($box, 'isGraph'));
    }
    
    public function testGetPetriBuilder()
    {
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->assertInstanceOf('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface', $box->getPetriBuilder());
    }

    public function getGetTransitionFromInputPoint()
    {
        $builder = $this->getMock('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface');
        $builder
            ->expects($this->once())
            ->method('addTransition')
            ->will($this->returnValue('newTransition'));
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createBuilder')
            ->will($this->returnValue($builder));

        $point = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'addInputPoint', array($point));
        $box->getPetriBuilder();
        $transition = $this->invokeMethod($box, 'getTransitionFromInputPoint', array($point));
        $this->assertSame('newTransition', $transition);
    }

    public function getGetTransitionFromOutputPoint()
    {
        $builder = $this->getMock('Geomagilles\FlowGraph\Petri\Builder\PetriBuilderInterface');
        $builder
            ->expects($this->once())
            ->method('addTransition')
            ->will($this->returnValue('newTransition'));
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createBuilder')
            ->will($this->returnValue($builder));

        $point = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'addOutputPoint', array($point));
        $box->getPetriBuilder();
        $transition = $this->invokeMethod($box, 'getTransitionFromOutputPoint', array($point));
        $this->assertSame('newTransition', $transition);
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetTransitionFromInputPointWithoutGetPetriBuilder()
    {
        $point = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'getTransitionFromInputPoint', array($point));
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetTransitionFromOutputPointWithoutGetPetriBuilder()
    {
        $point = $this->getMock('Geomagilles\FlowGraph\Point\PointInterface');
        $factory = $this->getMock('Geomagilles\FlowGraph\Factory\Flow\GraphFactoryInterface');
        $box = $this->getMockForAbstractClass(self::TESTED_CLASS, array('', $factory));
        $this->invokeMethod($box, 'getTransitionFromOutputPoint', array($point));
    }
}
