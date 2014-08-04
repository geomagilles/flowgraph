<?php
/**
 * This file is part of the Flow framework.
 *
 * (c) Gilles Barbier <geomagilles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geomagilles\FlowGraph\Tests\Graph\Element;

use Geomagilles\FlowGraph\Tests\BaseTest;

/**
 * Test class for Point.
 */
class ElementTest extends BaseTest
{
    const TESTEDCLASS = 'Geomagilles\FlowGraph\Element\Element';

    public function testConstructor()
    {
        $element = $this->getMockForAbstractClass(self::TESTEDCLASS, array('myName'));
        $this->assertSame('myName', $element->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithBadName()
    {
        $element = $this->getMockForAbstractClass(self::TESTEDCLASS, array(new \StdClass));
    }

    public function testGetSetName()
    {
        $element = $this->getMockForAbstractClass(self::TESTEDCLASS);
        $this->assertSame('', $element->getName());
        $element->setName('myName');
        $this->assertSame('myName', $element->getName());
    }

    public function testGetSetId()
    {
        $element = $this->getMockForAbstractClass(self::TESTEDCLASS);
        $this->assertStringMatchesFormat('%s%s%s%s%s%s%s%s%s%s%s%s%s', $element->getId());
        $element->setId('myId');
        $this->assertSame('myId', $element->getId());
    }
}
