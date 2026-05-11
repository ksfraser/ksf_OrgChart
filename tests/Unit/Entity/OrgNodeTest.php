<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\OrgChart\Entity;

use Ksfraser\OrgChart\Entity\OrgNode;
use PHPUnit\Framework\TestCase;

class OrgNodeTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $node = new OrgNode();

        $this->assertNull($node->getId());
        $this->assertNull($node->getParentId());
        $this->assertSame('', $node->getName());
        $this->assertSame('Department', $node->getType());
        $this->assertNull($node->getHeadId());
        $this->assertSame(0, $node->getLevel());
        $this->assertSame(0, $node->getSortOrder());
        $this->assertTrue($node->isActive());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setId
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getId
     */
    public function testSetId(): void
    {
        $node = new OrgNode();
        $result = $node->setId(1);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(1, $node->getId());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setParentId
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getParentId
     */
    public function testSetParentId(): void
    {
        $node = new OrgNode();
        $result = $node->setParentId(10);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(10, $node->getParentId());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setName
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getName
     */
    public function testSetName(): void
    {
        $node = new OrgNode();
        $result = $node->setName('Engineering');

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame('Engineering', $node->getName());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setType
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getType
     */
    public function testSetType(): void
    {
        $node = new OrgNode();
        $result = $node->setType(OrgNode::TYPE_DIVISION);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame('Division', $node->getType());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setHeadId
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getHeadId
     */
    public function testSetHeadId(): void
    {
        $node = new OrgNode();
        $result = $node->setHeadId(100);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(100, $node->getHeadId());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::isRoot
     */
    public function testIsRoot(): void
    {
        $node = new OrgNode();
        $this->assertTrue($node->isRoot());

        $node->setParentId(5);
        $this->assertFalse($node->isRoot());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::setLevel
     * @covers Ksfraser\OrgChart\Entity\OrgNode::getLevel
     */
    public function testSetLevel(): void
    {
        $node = new OrgNode();
        $result = $node->setLevel(3);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(3, $node->getLevel());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgNode::TYPE_COMPANY
     * @covers Ksfraser\OrgChart\Entity\OrgNode::TYPE_TEAM
     */
    public function testTypeConstants(): void
    {
        $this->assertSame('Company', OrgNode::TYPE_COMPANY);
        $this->assertSame('Division', OrgNode::TYPE_DIVISION);
        $this->assertSame('Department', OrgNode::TYPE_DEPARTMENT);
        $this->assertSame('Team', OrgNode::TYPE_TEAM);
    }
}