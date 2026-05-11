<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\OrgChart\Service;

use Ksfraser\OrgChart\Entity\OrgNode;
use Ksfraser\OrgChart\Entity\OrgEdge;
use Ksfraser\OrgChart\Service\OrgChartService;
use PHPUnit\Framework\TestCase;

class OrgChartServiceTest extends TestCase
{
    private OrgChartService $service;

    protected function setUp(): void
    {
        $this->service = new OrgChartService();
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::createNode
     */
    public function testCreateNodeSuccess(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Engineering',
            'type' => OrgNode::TYPE_DIVISION,
            'head_id' => 100,
        ];

        $node = $this->service->createNode($data);

        $this->assertInstanceOf(OrgNode::class, $node);
        $this->assertSame(1, $node->getId());
        $this->assertSame('Engineering', $node->getName());
        $this->assertSame('Division', $node->getType());
        $this->assertSame(100, $node->getHeadId());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::createNode
     */
    public function testCreateNodeMinimal(): void
    {
        $data = ['name' => 'Minimal'];

        $node = $this->service->createNode($data);

        $this->assertInstanceOf(OrgNode::class, $node);
        $this->assertSame('Minimal', $node->getName());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::getNode
     */
    public function testGetNode(): void
    {
        $this->service->createNode(['id' => 10, 'name' => 'FindMe']);

        $node = $this->service->getNode(10);

        $this->assertNotNull($node);
        $this->assertSame('FindMe', $node->getName());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::getRootNodes
     */
    public function testGetRootNodes(): void
    {
        $this->service->createNode(['id' => 1, 'name' => 'Root']);
        $this->service->createNode(['id' => 2, 'name' => 'Child', 'parent_id' => 1]);
        $this->service->createNode(['id' => 3, 'name' => 'Standalone']);

        $roots = $this->service->getRootNodes();

        $this->assertCount(2, $roots);
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::getChildren
     */
    public function testGetChildren(): void
    {
        $this->service->createNode(['id' => 1, 'name' => 'Parent']);
        $this->service->createNode(['id' => 2, 'name' => 'C1', 'parent_id' => 1, 'sort_order' => 0]);
        $this->service->createNode(['id' => 3, 'name' => 'C2', 'parent_id' => 1, 'sort_order' => 1]);
        $this->service->createNode(['id' => 4, 'name' => 'Other', 'parent_id' => 999]);

        $children = $this->service->getChildren(1);

        $this->assertCount(2, $children);
        $this->assertSame('C1', $children[0]->getName());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::addEdge
     */
    public function testAddEdge(): void
    {
        $edge = $this->service->addEdge(1, 2, OrgEdge::TYPE_MANAGES);

        $this->assertInstanceOf(OrgEdge::class, $edge);
        $this->assertSame(1, $edge->getFromNodeId());
        $this->assertSame(2, $edge->getToNodeId());
        $this->assertSame('manages', $edge->getType());
        $this->assertNotNull($edge->getEffectiveDate());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::getReportingChain
     */
    public function testGetReportingChain(): void
    {
        $this->service->createNode(['id' => 1, 'name' => 'CEO', 'type' => OrgNode::TYPE_COMPANY]);
        $this->service->createNode(['id' => 2, 'name' => 'VP', 'parent_id' => 1]);
        $this->service->createNode(['id' => 3, 'name' => 'Manager', 'parent_id' => 2]);
        $this->service->createNode(['id' => 4, 'name' => 'Individual', 'parent_id' => 3]);

        $chain = $this->service->getReportingChain(4);

        $this->assertCount(3, $chain);
        $this->assertSame('Manager', $chain[0]->getName());
        $this->assertSame('VP', $chain[1]->getName());
    }

    /**
     * @covers Ksfraser\OrgChart\Service\OrgChartService::countDescendants
     */
    public function testCountDescendants(): void
    {
        $this->service->createNode(['id' => 1, 'name' => 'Root']);
        $this->service->createNode(['id' => 2, 'name' => 'Child1', 'parent_id' => 1]);
        $this->service->createNode(['id' => 3, 'name' => 'Child2', 'parent_id' => 1]);
        $this->service->createNode(['id' => 4, 'name' => 'Grandchild', 'parent_id' => 2]);

        $count = $this->service->countDescendants(1);

        $this->assertSame(3, $count);
    }
}