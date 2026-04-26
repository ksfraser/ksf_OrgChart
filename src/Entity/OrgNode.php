<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Entity;

class OrgNode
{
    public const TYPE_EMPLOYEE = 'Employee';
    public const TYPE_MANAGER = 'Manager';
    public const TYPE_DEPARTMENT_HEAD = 'Department Head';
    public const TYPE_EXECUTIVE = 'Executive';

    private ?int $id = null;
    private int $employeeId = 0;
    private ?int $careerManagerId = null;
    private ?int $operationsManagerId = null;
    private string $nodeType = self::TYPE_EMPLOYEE;
    private string $department = '';
    private ?int $costCenterId = null;
    private bool $isActive = true;
    private ?int $directReportsCount = null;
    private ?string $effectiveDate = null;
    private ?string $endDate = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getCareerManagerId(): ?int { return $this->careerManagerId; }
    public function setCareerManagerId(?int $careerManagerId): self { $this->careerManagerId = $careerManagerId; return $this; }
    public function getOperationsManagerId(): ?int { return $this->operationsManagerId; }
    public function setOperationsManagerId(?int $operationsManagerId): self { $this->operationsManagerId = $operationsManagerId; return $this; }
    public function getNodeType(): string { return $this->nodeType; }
    public function setNodeType(string $nodeType): self { $this->nodeType = $nodeType; return $this; }
    public function getDepartment(): string { return $this->department; }
    public function setDepartment(string $department): self { $this->department = $department; return $this; }
    public function getCostCenterId(): ?int { return $this->costCenterId; }
    public function setCostCenterId(?int $costCenterId): self { $this->costCenterId = $costCenterId; return $this; }
    public function isActive(): bool { return $this->isActive; }
    public function setActive(bool $isActive): self { $this->isActive = $isActive; return $this; }
    public function getDirectReportsCount(): ?int { return $this->directReportsCount; }
    public function setDirectReportsCount(?int $directReportsCount): self { $this->directReportsCount = $directReportsCount; return $this; }
    public function getEffectiveDate(): ?string { return $this->effectiveDate; }
    public function setEffectiveDate(?string $effectiveDate): self { $this->effectiveDate = $effectiveDate; return $this; }
    public function getEndDate(): ?string { return $this->endDate; }
    public function setEndDate(?string $endDate): self { $this->endDate = $endDate; return $this; }

    public function isManager(): bool
    {
        return in_array($this->nodeType, [self::TYPE_MANAGER, self::TYPE_DEPARTMENT_HEAD, self::TYPE_EXECUTIVE], true);
    }

    public function hasDirectReports(): bool
    {
        return $this->directReportsCount !== null && $this->directReportsCount > 0;
    }

    public function hasDualReporting(): bool
    {
        return $this->careerManagerId !== null && $this->operationsManagerId !== null 
            && $this->careerManagerId !== $this->operationsManagerId;
    }
}