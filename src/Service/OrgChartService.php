<?php

declare(strict_types=1);

namespace Ksfraser\OrgChart\Service;

use Ksfraser\OrgChart\Entity\OrgNode;

class OrgChartService
{
    public function getReportingChain(OrgNode $node, string $type = 'career'): array
    {
        $chain = [];
        $currentId = $type === 'career' ? $node->getCareerManagerId() : $node->getOperationsManagerId();
        
        while ($currentId !== null) {
            $chain[] = $currentId;
            // Would query parent - simplified for entity only
            break; 
        }
        
        return $chain;
    }

    public function getDirectReports(OrgNode $manager): array
    {
        // Would query DB for direct reports
        return [];
    }

    public function get扁平View(OrgNode $node): array
    {
        return [
            'employee_id' => $node->getEmployeeId(),
            'career_manager' => $node->getCareerManagerId(),
            'operations_manager' => $node->getOperationsManagerId(),
            'department' => $node->getDepartment(),
            'type' => $node->getNodeType(),
        ];
    }

    public function canApprove(OrgNode $approver, OrgNode $requestee, string $type = 'career'): bool
    {
        $managerId = $type === 'career' 
            ? $approver->getCareerManagerId() 
            : $approver->getOperationsManagerId();
        
        return $managerId === $requestee->getEmployeeId();
    }
}