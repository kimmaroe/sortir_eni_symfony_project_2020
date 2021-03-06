<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 * @UniqueEntity(
 *     fields={"event", "participant"},
 *     errorPath="particpant",
 *     message="Vous êtes déjà inscrit à cette sortie."
 * )
 */

class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $participant;



    public function getRegistrationDate(): ?DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getParticipant(): ?User
    {
        return $this->participant;
    }

    public function setParticipant(User $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
