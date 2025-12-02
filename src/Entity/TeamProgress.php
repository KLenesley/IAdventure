<?php

namespace App\Entity;

use App\Repository\TeamProgressRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamProgressRepository::class)]
#[ORM\Table(name: 'tbl_team_progress')]
class TeamProgress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TeamSession::class, inversedBy: 'progress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeamSession $teamSession = null;

    #[ORM\ManyToOne(targetEntity: Enigma::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enigma $enigma = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(length: 50)]
    private ?string $action = null; // 'started', 'completed', 'failed_attempt'

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    public function __construct()
    {
        $this->timestamp = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamSession(): ?TeamSession
    {
        return $this->teamSession;
    }

    public function setTeamSession(?TeamSession $teamSession): static
    {
        $this->teamSession = $teamSession;

        return $this;
    }

    public function getEnigma(): ?Enigma
    {
        return $this->enigma;
    }

    public function setEnigma(?Enigma $enigma): static
    {
        $this->enigma = $enigma;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }
}
