<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Service;

use Ksfraser\OrgChart\Entity\OrgNode;
use Ksfraser\OrgChart\Entity\OrgEdge;

class OrgChartService
{
    private array $nodes = [];
    private array $edges = [];

    public function createNode(array $data): OrgNode
    {
        $node = new OrgNode();
        if (isset($data['id'])) {
            $node->setId($data['id']);
        }
        $node->setParentId($data['parent_id'] ?? null);
        $node->setName($data['name'] ?? '');
        $node->setType($data['type'] ?? OrgNode::TYPE_DEPARTMENT);
        $node->setHeadId($data['head_id'] ?? null);
        $node->setLevel($data['level'] ?? 0);
        $node->setSortOrder($data['sort_order'] ?? 0);
        $node->setActive($data['active'] ?? true);

        $this->nodes[$node->getId() ?? count($this->nodes) + 1] = $node;
        return $node;
    }

    public function getNode(int $nodeId): ?OrgNode
    {
        return $this->nodes[$nodeId] ?? null;
    }

    public function getChildren(int $parentId): array
    {
        $children = [];
        foreach ($this->nodes as $node) {
            if ($node->getParentId() === $parentId && $node->isActive()) {
                $children[] = $node;
            }
        }
        usort($children, fn($a, $b) => $a->getSortOrder() <=> $b->getSortOrder());
        return $children;
    }

    public function getRootNodes(): array
    {
        $roots = [];
        foreach ($this->nodes as $node) {
            if ($node->isRoot() && $node->isActive()) {
                $roots[] = $node;
            }
        }
        return $roots;
    }

    public function addEdge(int $fromNodeId, int $toNodeId, string $type = OrgEdge::TYPE_MANAGES): OrgEdge
    {
        $edge = new OrgEdge();
        $edge->setFromNodeId($fromNodeId);
        $edge->setToNodeId($toNodeId);
        $edge->setType($type);
        $edge->setEffectiveDate(date('Y-m-d'));

        $this->edges[] = $edge;
        return $edge;
    }

    public function getReportingChain(int $nodeId): array
    {
        $chain = [];
        $current = $this->getNode($nodeId);

        while ($current !== null && $current->getParentId() !== null) {
            $parent = $this->getNode($current->getParentId());
            if ($parent !== null) {
                $chain[] = $parent;
                $current = $parent;
            } else {
                break;
            }
        }

        return $chain;
    }

    public function countDescendants(int $nodeId): int
    {
        $count = 0;
        $children = $this->getChildren($nodeId);

        foreach ($children as $child) {
            $count++;
            $count += $this->countDescendants($child->getId());
        }

        return $count;
    }
}