<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Entity;

class OrgNode
{
    public const TYPE_COMPANY = 'Company';
    public const TYPE_DIVISION = 'Division';
    public const TYPE_DEPARTMENT = 'Department';
    public const TYPE_TEAM = 'Team';

    private ?int $id = null;
    private ?int $parentId = null;
    private string $name = '';
    private string $type = self::TYPE_DEPARTMENT;
    private ?int $headId = null;
    private int $level = 0;
    private int $sortOrder = 0;
    private bool $active = true;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getParentId(): ?int { return $this->parentId; }
    public function setParentId(?int $parentId): self { $this->parentId = $parentId; return $this; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getHeadId(): ?int { return $this->headId; }
    public function setHeadId(?int $headId): self { $this->headId = $headId; return $this; }
    public function getLevel(): int { return $this->level; }
    public function setLevel(int $level): self { $this->level = $level; return $this; }
    public function getSortOrder(): int { return $this->sortOrder; }
    public function setSortOrder(int $sortOrder): self { $this->sortOrder = $sortOrder; return $this; }
    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): self { $this->active = $active; return $this; }
    public function isRoot(): bool { return $this->parentId === null; }
}