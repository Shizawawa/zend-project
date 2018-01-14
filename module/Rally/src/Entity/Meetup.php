<?php

declare(strict_types=1);

namespace Rally\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Meetup
 *
 * Attention : Doctrine génère des classes proxy qui étendent les entités, celles-ci ne peuvent donc pas être finales !
 *
 * @package Rally\Entity
 * @ORM\Entity(repositoryClass="\Rally\Repository\MeetupRepository")
 * @ORM\Table(name="meetups")
 */
class Meetup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     **/
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2000, nullable=false)
     */
    private $description = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $dateEnd;

    /**
     * @ORM\ManyToMany(targetEntity="\Person\Entity\Person", inversedBy="pmeetups")
     * @ORM\JoinTable(name="meetup_participant",
     *      joinColumns={@ORM\JoinColumn(name="meetup_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     *      )
     */
    protected $participants;

    /**
     * @ORM\ManyToMany(targetEntity="\Person\Entity\Person", inversedBy="omeetups")
     * @ORM\JoinTable(name="meetup_organizer",
     *      joinColumns={@ORM\JoinColumn(name="meetup_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     *      )
     */
    protected $organizers;

    /**
     * @ORM\ManyToOne(targetEntity="\Person\Entity\Organization", inversedBy="meetups")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     */
    protected $organization;

    public function __construct(string $title, string $description = '', string $dateBegin, string $dateEnd)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->title = $title;
        $this->description = $description;
        $this->dateBegin = $dateBegin;
        $this->dateEnd = $dateEnd;
        $this->participants = new ArrayCollection();
        $this->organizers = new ArrayCollection();
    }

    /**
     * return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getDateBegin() : string
    {
        return $this->dateBegin;
    }

    public function getDateEnd() : string
    {
        return $this->dateEnd;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function setDateBegin(string $dateBegin) : void
    {
        $this->dateBegin = $dateBegin;
    }

    public function setDateEnd(string $dateEnd) : void
    {
        $this->dateEnd = $dateEnd;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    // Returns participating persons for this meetup.
    public function getParticipants()
    {
        return $this->participants;
    }

    // Adds a new participating person to this meetup.
    public function addParticipants($person)
    {
        $this->participants[] = $person;
    }

    // Removes association between this meetup and the given participating person.
    public function removeParticipantAssociation($person)
    {
        $this->participants->removeElement($person);
    }

    // Returns organizing persons for this meetup.
    public function getOrganizers()
    {
        return $this->organizers;
    }

    // Adds a new organizing person to this meetup.
    public function addOrganizers($person)
    {
        $this->organizers[] = $person;
    }

    // Removes association between this meetup and the given organizing person.
    public function removeOrganizerAssociation($person)
    {
        $this->organizers->removeElement($person);
    }
    /**
     * return associated organization
     * @return \Person\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Sets associated organization.
     * @param \Person\Entity\Organization $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
        $organization->addMeetup($this);
    }

    public function getArrayCopy()
    {
        return $this;
    }

    public function exchangeArray($data)
    {
        $this->title  = isset($data['title']) ? $data['title'] : null;
        $this->description  = isset($data['description']) ? $data['description'] : null;
        $this->dateBegin  = isset($data['dateBegin']) ? $data['dateBegin'] : null;
        $this->dateEnd  = isset($data['dateEnd']) ? $data['dateEnd'] : null;
    }
}
