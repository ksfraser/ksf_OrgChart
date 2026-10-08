<?php

declare(strict_types=1);

namespace ksfraser\Tests\Unit\OrgChart\Entity;

use ksfraser\OrgChart\Entity\OrgNode;
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
     * @covers ksfraser\OrgChart\Entity\OrgNode::setId
     * @covers ksfraser\OrgChart\Entity\OrgNode::getId
     */
    public function testSetId(): void
    {
        $node = new OrgNode();
        $result = $node->setId(1);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(1, $node->getId());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::setParentId
     * @covers ksfraser\OrgChart\Entity\OrgNode::getParentId
     */
    public function testSetParentId(): void
    {
        $node = new OrgNode();
        $result = $node->setParentId(10);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(10, $node->getParentId());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::setName
     * @covers ksfraser\OrgChart\Entity\OrgNode::getName
     */
    public function testSetName(): void
    {
        $node = new OrgNode();
        $result = $node->setName('Engineering');

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame('Engineering', $node->getName());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::setType
     * @covers ksfraser\OrgChart\Entity\OrgNode::getType
     */
    public function testSetType(): void
    {
        $node = new OrgNode();
        $result = $node->setType(OrgNode::TYPE_DIVISION);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame('Division', $node->getType());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::setHeadId
     * @covers ksfraser\OrgChart\Entity\OrgNode::getHeadId
     */
    public function testSetHeadId(): void
    {
        $node = new OrgNode();
        $result = $node->setHeadId(100);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(100, $node->getHeadId());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::isRoot
     */
    public function testIsRoot(): void
    {
        $node = new OrgNode();
        $this->assertTrue($node->isRoot());

        $node->setParentId(5);
        $this->assertFalse($node->isRoot());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::setLevel
     * @covers ksfraser\OrgChart\Entity\OrgNode::getLevel
     */
    public function testSetLevel(): void
    {
        $node = new OrgNode();
        $result = $node->setLevel(3);

        $this->assertInstanceOf(OrgNode::class, $result);
        $this->assertSame(3, $node->getLevel());
    }

    /**
     * @covers ksfraser\OrgChart\Entity\OrgNode::TYPE_COMPANY
     * @covers ksfraser\OrgChart\Entity\OrgNode::TYPE_TEAM
     */
    public function testTypeConstants(): void
    {
        $this->assertSame('Company', OrgNode::TYPE_COMPANY);
        $this->assertSame('Division', OrgNode::TYPE_DIVISION);
        $this->assertSame('Department', OrgNode::TYPE_DEPARTMENT);
        $this->assertSame('Team', OrgNode::TYPE_TEAM);
    }
}