<?php
declare(strict_types=1);

namespace Person\Repository;

use Person\Entity\Person;
use Doctrine\ORM\EntityRepository;

final class PersonRepository extends EntityRepository
{
    public function add($person) : void
    {
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush($person);
    }

    public function createPersonFromFirstnameAndLastname(string $firstname, string $lastname)
    {
        return new Person($firstname, $lastname);
    }
}