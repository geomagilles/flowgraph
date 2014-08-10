<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Graph\Point;

use Geomagilles\FlowGraph\Tests\BaseTest;
use Geomagilles\FlowGraph\Points\Point;

/**
 * Test class for Point.
 */
class PointTest extends BaseTest
{
    public function testConstructor()
    {
        $point = new Point();
        $this->assertInstanceOf('Geomagilles\FlowGraph\Element\ElementInterface', $point);
        $this->assertSame('', $point->getName());
    }

    public function testConstructorWithName()
    {
        $point = new Point('myName');
        $this->assertSame('myName', $point->getName());
    }

    public function testGetSetBox()
    {
        $box = $this->getMock('Geomagilles\FlowGraph\Box\BoxInterface');
        $point = new Point();
        $this->assertNull($point->getBox());
        $point->setBox($box);
        $this->assertSame($box, $point->getBox());
    }
    
    public function testGetSetSubjascentPoint()
    {
        $subj = $this->getMock('Geomagilles\FlowGraph\Points\PointInterface');
        $point = new Point();
        $this->assertNull($point->getSubjacentPoint());
        $point->setSubjacentPoint($subj);
        $this->assertSame($subj, $point->getSubjacentPoint());
    }

    public function testAddArcBegin()
    {
        $point = new Point();
        $arc = $this->getMock('Geomagilles\FlowGraph\Arc\ArcInterface');
        $arc
            ->expects($this->at(0))
            ->method('getBeginPoint')
            ->will($this->returnValue($point));

        $point->addArc($arc);
        $arcs = $point->getArcs();
        $this->assertSame($arc, $arcs[0]);
    }

    public function testAddArcEnd()
    {
        $point = new Point();
        $arc = $this->getMock('Geomagilles\FlowGraph\Arc\ArcInterface');
        $arc
            ->expects($this->at(1))
            ->method('getEndPoint')
            ->will($this->returnValue($point));

        $this->assertCount(0, $point->getArcs());
        $this->assertFalse($point->hasAnyArc());
        $this->assertEquals(0, $point->countArcs());

        $point->addArc($arc);
        $arcs = $point->getArcs();
        
        $this->assertCount(1, $arcs);
        $this->assertTrue($point->hasAnyArc());
        $this->assertEquals(1, $point->countArcs());
        $this->assertSame($arc, $arcs[0]);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddArcNopoint()
    {
        $point = new Point();
        $arc = $this->getMock('Geomagilles\FlowGraph\Arc\ArcInterface');
        $point->addArc($arc);
    }
}
