<?php

namespace App\Entity;

use App\Repository\GameSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameSessionRepository::class)]
#[ORM\Table(name: 'tbl_game_session')]
class GameSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: 'gameSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'in_progress';

    /**
     * @var Collection<int, TeamSession>
     */
    #[ORM\OneToMany(targetEntity: TeamSession::class, mappedBy: 'gameSession', cascade: ['persist', 'remove'])]
    private Collection $teamSessions;

    public function __construct()
    {
        $this->teamSessions = new ArrayCollection();
        $this->startedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, TeamSession>
     */
    public function getTeamSessions(): Collection
    {
        return $this->teamSessions;
    }

    public function addTeamSession(TeamSession $teamSession): static
    {
        if (!$this->teamSessions->contains($teamSession)) {
            $this->teamSessions->add($teamSession);
            $teamSession->setGameSession($this);
        }

        return $this;
    }

    public function removeTeamSession(TeamSession $teamSession): static
    {
        if ($this->teamSessions->removeElement($teamSession)) {
            // set the owning side to null (unless already changed)
            if ($teamSession->getGameSession() === $this) {
                $teamSession->setGameSession(null);
            }
        }

        return $this;
    }
}
