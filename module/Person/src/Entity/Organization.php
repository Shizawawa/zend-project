<?php
declare(strict_types=1);

namespace Person\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Organization
 *
 * Attention : Doctrine génère des classes proxy qui étendent les entités, celles-ci ne peuvent donc pas être finales !
 *
 * @package Person\Entity
 * @ORM\Entity(repositoryClass="\Person\Repository\OrganizationRepository")
 * @ORM\Table(name="organizations")
 */
class Organization
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     **/
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     **/
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="\Rally\Entity\Meetup", mappedBy="organization")
     * @ORM\JoinColumn(name="id", referencedColumnName="organisation_id")
     */
    protected $meetups;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->meetups = new ArrayCollection();
    }

    /**
     * return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Returns meetups for this organization.
     * @return ArrayCollection
     */
    public function getMeetups()
    {
        return $this->meetups;
    }

    /**
     * Adds a new meetup to this organization.
     * @param $meetup
     */
    public function addMeetup($meetup)
    {
        $this->meetups[] = $meetup;
    }

}