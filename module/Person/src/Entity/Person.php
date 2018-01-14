<?php
declare(strict_types=1);

namespace Person\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Person
 *
 * Attention : Doctrine génère des classes proxy qui étendent les entités, celles-ci ne peuvent donc pas être finales !
 *
 * @package Person\Entity
 * @ORM\Entity(repositoryClass="\Person\Repository\PersonRepository")
 * @ORM\Table(name="persons")
 */

class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     **/
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     **/
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     **/
    private $lastname;

    /**
     * @ORM\ManyToMany(targetEntity="\Rally\Entity\Meetup", mappedBy="participants")
     */
    private $pmeetups;

    /**
     * @ORM\ManyToMany(targetEntity="\Rally\Entity\Meetup", mappedBy="organizers")
     */
    private $omeetups;

    public function __construct(string $firstname, string $lastname)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->pmeetups = new ArrayCollection();
        $this->omeetups = new ArrayCollection();
    }

    /**
     * return string
     */
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function getLastname() : string
    {
        return $this->lastname;
    }

    // Returns participating meetups associated with this person.
    public function getPmeetups()
    {
        return $this->pmeetups;
    }

    // Adds a participating meetups into collection of participating meetups related to this person.
    public function addPmeetup($meetup)
    {
        $this->pmeetups[] = $meetup;
    }

    // Returns organizing meetups associated with this person.
    public function getOmeetups()
    {
        return $this->omeetups;
    }

    // Adds a organizing meetups into collection of organizing meetups related to this person.
    public function addOmeetup($meetup)
    {
        $this->omeetups[] = $meetup;
    }
}