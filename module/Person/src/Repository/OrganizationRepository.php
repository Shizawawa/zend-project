<?php
declare(strict_types=1);

namespace Person\Repository;

use Person\Entity\Organization;
use Doctrine\ORM\EntityRepository;


class OrganizationRepository extends EntityRepository
{
    public function add($organization) : void
    {
        $this->getEntityManager()->persist($organization);
        $this->getEntityManager()->flush($organization);
    }

    public function createOrganizationFromName(string $name)
    {
        return new Organization($name);
    }
}