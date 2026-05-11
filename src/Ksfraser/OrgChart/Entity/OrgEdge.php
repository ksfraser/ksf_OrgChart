<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Entity;

class OrgEdge
{
    public const TYPE_MANAGES = 'manages';
    public const TYPE_REPORTS_TO = 'reports_to';
    public const TYPE_COLLEAGUE = 'colleague';

    private ?int $id = null;
    private int $fromNodeId = 0;
    private int $toNodeId = 0;
    private string $type = self::TYPE_MANAGES;
    private ?string $effectiveDate = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getFromNodeId(): int { return $this->fromNodeId; }
    public function setFromNodeId(int $fromNodeId): self { $this->fromNodeId = $fromNodeId; return $this; }
    public function getToNodeId(): int { return $this->toNodeId; }
    public function setToNodeId(int $toNodeId): self { $this->toNodeId = $toNodeId; return $this; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getEffectiveDate(): ?string { return $this->effectiveDate; }
    public function setEffectiveDate(?string $effectiveDate): self { $this->effectiveDate = $effectiveDate; return $this; }
}