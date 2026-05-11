<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\OrgChart\Entity;

use Ksfraser\OrgChart\Entity\OrgEdge;
use PHPUnit\Framework\TestCase;

class OrgEdgeTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $edge = new OrgEdge();

        $this->assertNull($edge->getId());
        $this->assertSame(0, $edge->getFromNodeId());
        $this->assertSame(0, $edge->getToNodeId());
        $this->assertSame('manages', $edge->getType());
        $this->assertNull($edge->getEffectiveDate());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::setFromNodeId
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::getFromNodeId
     */
    public function testSetFromNodeId(): void
    {
        $edge = new OrgEdge();
        $result = $edge->setFromNodeId(1);

        $this->assertInstanceOf(OrgEdge::class, $result);
        $this->assertSame(1, $edge->getFromNodeId());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::setToNodeId
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::getToNodeId
     */
    public function testSetToNodeId(): void
    {
        $edge = new OrgEdge();
        $result = $edge->setToNodeId(2);

        $this->assertInstanceOf(OrgEdge::class, $result);
        $this->assertSame(2, $edge->getToNodeId());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::setType
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::getType
     */
    public function testSetType(): void
    {
        $edge = new OrgEdge();
        $result = $edge->setType(OrgEdge::TYPE_REPORTS_TO);

        $this->assertInstanceOf(OrgEdge::class, $result);
        $this->assertSame('reports_to', $edge->getType());
    }

    /**
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::setEffectiveDate
     * @covers Ksfraser\OrgChart\Entity\OrgEdge::getEffectiveDate
     */
    public function testSetEffectiveDate(): void
    {
        $edge = new OrgEdge();
        $result = $edge->setEffectiveDate('2026-01-01');

        $this->assertInstanceOf(OrgEdge::class, $result);
        $this->assertSame('2026-01-01', $edge->getEffectiveDate());
    }
}