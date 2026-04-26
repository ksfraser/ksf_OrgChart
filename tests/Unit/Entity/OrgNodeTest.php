<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\OrgChart\Entity\OrgNode;

class OrgNodeTest extends TestCase
{
    public function testCanCreateOrgNode(): void
    {
        $node = new OrgNode();
        $this->assertInstanceOf(OrgNode::class, $node);
    }

    public function testCanSetDualReporting(): void
    {
        $node = new OrgNode();
        $node->setEmployeeId(1);
        $node->setCareerManagerId(2);
        $node->setOperationsManagerId(3);
        
        $this->assertEquals(1, $node->getEmployeeId());
        $this->assertEquals(2, $node->getCareerManagerId());
        $this->assertEquals(3, $node->getOperationsManagerId());
    }

    public function testCanSetNodeType(): void
    {
        $node = new OrgNode();
        $node->setNodeType(OrgNode::TYPE_DEPARTMENT_HEAD);
        $this->assertEquals(OrgNode::TYPE_DEPARTMENT_HEAD, $node->getNodeType());
    }

    public function testCanSetDepartment(): void
    {
        $node = new OrgNode();
        $node->setDepartment('Engineering');
        $this->assertEquals('Engineering', $node->getDepartment());
    }

    public function testCanCheckIsManager(): void
    {
        $node = new OrgNode();
        $node->setNodeType(OrgNode::TYPE_MANAGER);
        $this->assertTrue($node->isManager());
        
        $node->setNodeType(OrgNode::TYPE_EMPLOYEE);
        $this->assertFalse($node->isManager());
    }

    public function testCanCheckHasDirectReports(): void
    {
        $node = new OrgNode();
        $node->setDirectReportsCount(5);
        $this->assertTrue($node->hasDirectReports());
        $this->assertEquals(5, $node->getDirectReportsCount());
    }
}