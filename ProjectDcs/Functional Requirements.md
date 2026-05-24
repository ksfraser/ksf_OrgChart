# Functional Requirements - ksf_OrgChart

## Document Information
- **Module**: ksf_OrgChart
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Implemented
- **Author**: KSFII Development Team

---

## 1. Overview

### 1.1 Purpose
ksf_OrgChart provides organizational hierarchy visualization with support for dual reporting structures (HRM hierarchy and Project team context).

### 1.2 Scope
- Hierarchical node management
- Dual context support (HRM/Project)
- SVG visualization
- Interactive exploration

---

## 2. Core Entities

### 2.1 OrgNode

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| name | string | Yes | Node name |
| parent_id | string | No | Parent node ID |
| head_id | string | No | Employee/head ID |
| type | enum | Yes | department/position/team |
| level | int | Yes | Hierarchy level |
| status | enum | Yes | active/inactive |

### 2.2 OrgEdge

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| source_id | string | Yes | Source node |
| target_id | string | Yes | Target node |
| type | enum | Yes | reports_to/project_team |

---

## 3. Functional Requirements

### FR-ORG-001: Node Management
**Requirement**: System shall create and manage org chart nodes.

**Features**:
- Create nodes with hierarchy
- Set parent-child relationships
- Link to employee records
- Activate/deactivate nodes

### FR-ORG-002: Dual Context
**Requirement**: System shall support HRM and Project contexts.

**Features**:
- HRM mode: Reporting hierarchy
- Project mode: Team structure
- Context toggle
- Role badges for project

### FR-ORG-003: Hierarchy Operations
**Requirement**: System shall traverse and query hierarchy.

**Features**:
- Get children
- Get manager chain
- Get direct reports
- Calculate depth

### FR-ORG-004: RBAC Team Provisioning
**Requirement**: System shall auto-provision RBAC teams from org chart position changes.

**Features**:
- On position change, update {managerId}_direct team membership
- Cascade updates to {managerId}_indirect_lX teams (configurable depth)
- Remove user from prior manager's teams on reassignment
- Write audit trail for all team membership changes

### FR-ORG-005: Entity Projections
**Requirement**: System shall expose PUBLIC and FULL projections for RBAC.

**Features**:
- PUBLIC projection: title, department, status
- FULL projection: salary_band, cost_center, succession_plan
- HR Admin sees FULL; Managers see PUBLIC + direct reports
- Employees see only PUBLIC for own position

### FR-ORG-006: Soft Delete
**Requirement**: System shall support soft deletion of org positions and units.

**Features**:
- Positions set inactive flag on delete
- Org units cascade deactivate to child positions
- Hard delete restricted to super-admin
- History preserved for audit

### FR-ORG-007: Audit Trail
**Requirement**: System shall audit all org chart changes.

**Features**:
- Log position creation, updates, deletion
- Log manager assignment changes
- Log team provisioning events
- Audit trail viewable by HR and super-admin

---

## 4. Events

| Event | Trigger |
|-------|---------|
| orgchart.node.created | New node |
| orgchart.node.updated | Node updated |
| orgchart.node.deleted | Node deleted |
| orgchart.edge.created | New relationship |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*