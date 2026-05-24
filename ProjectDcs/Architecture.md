# Architecture - ksf_OrgChart

## Document Information
- **Module**: ksf_OrgChart
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_OrgChart manages organizational hierarchy and reporting relationships. It provides the org chart structure used by ksfraser/rbac for auto-creating team hierarchies (_direct, _indirect_lX teams).

### 1.1 Namespace
```php
Ksfraser\OrgChart\
```

### 1.2 Layer Pattern
```
ksf_OrgChart/                → Business Logic
    ├── Entity/              → Domain entities
    ├── Service/             → Business services
    └── Repository/          → Data access interfaces
```

---

## 2. Core Entities

### 2.1 OrgPosition
```php
class OrgPosition {
    private string $id;
    private string $title;
    private ?string $parentPositionId;  // Manager position
    private ?string $employeeId;        // Current occupant
    private \DateTime $effectiveDate;
    private ?\DateTime $endDate;
    private PositionStatus $status;     // filled, vacant, frozen
}
```

### 2.2 OrgUnit (Department)
```php
class OrgUnit {
    private string $id;
    private string $name;
    private ?string $parentUnitId;
    private ?string $managerPositionId;  // Head of department
    private string $costCenter;
    private OrgUnitType $type;           // department, division, team
}
```

---

## 3. RBAC Integration (ksfraser/rbac)

### 3.1 Auto-Team Provisioning

The OrgChart module is the PRIMARY source of auto-team creation for RBAC:

On position change (employee E moves from manager M1 to M2):
1. Remove E from M1_direct team, cascade removal from M1_indirect_lX
2. Add E to M2_direct team, cascade add to M2_indirect_lX (up to configured depth)
3. Audit trail written for all team membership changes

### 3.2 Team Naming Convention

| Org Relationship | RBAC Team ID | team_type |
|----------------|--------------|-----------|
| Position occupant → direct manager | {managerId}_direct | org_direct |
| Manager → skip-level reports | {managerId}_indirect_l1 | org_indirect |
| N-levels up | {managerId}_indirect_l{level} | org_indirect |

### 3.3 Module Registration

ksf_OrgChart registers with ksfraser/rbac:
- record_types: 'org_position', 'org_unit'
- projections: 'public' (title, department, status), 'full' (all fields including salary_band, cost_center, succession_plan)
- allow_invite: false

### 3.4 Access Model

- **HR Admin**: FULL to all positions and org units (PROJECTION_FULL)
- **Manager**: View own org unit structure (PROJECTION_PUBLIC), view direct reports
- **Employee**: View own position and manager (PROJECTION_PUBLIC)
- **Executive**: View full org chart (PROJECTION_PUBLIC), no edit

### 3.5 SQL Enforcement

Standard RBAC JOIN pattern for org_position and org_unit queries.

### 3.6 Persons Registry

OrgChart positions link to employees via employeeId → crm_persons.id for cross-module identity resolution.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*
