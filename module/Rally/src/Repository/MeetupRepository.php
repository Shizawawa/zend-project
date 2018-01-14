<?php

declare(strict_types=1);

namespace Rally\Repository;

use Rally\Entity\Meetup;
use Doctrine\ORM\EntityRepository;

final class MeetupRepository extends EntityRepository
{

    public function add($meetup) : void
    {
        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);
    }

    public function createMeetupFromNameAndDescription(string $name, string $description, string $dateBegin, string $dateEnd)
    {
        return new Meetup($name, $description, $dateBegin, $dateEnd);
    }

    public function deleteMeetup($id)
    {
        $meetup = $this->getEntityManager()->getRepository(Meetup::class)->findOneBy(array('id' => $id));
        $this->getEntityManager()->remove($meetup);
        $this->getEntityManager()->flush();

    }

    public function findMeetup($id)
    {
        $meetup = $this->getEntityManager()->getRepository(Meetup::class)->findOneBy(array('id' => $id));
        return $meetup;
    }

    public function updateMeetup($id, $data)
    {
        $meetup = $this->getEntityManager()->getRepository(Meetup::class)->findOneBy(array('id' => $id));
        $meetup->setTitle($data['title']);
        $meetup->setDescription($data['description']);
        $meetup->setDateBegin($data['dateBegin']);
        $meetup->setDateEnd($data['dateEnd']);
        $this->getEntityManager()->flush();
    }
}
