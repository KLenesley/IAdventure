<?php

namespace App\Entity;

use App\Repository\TeamSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamSessionRepository::class)]
#[ORM\Table(name: 'tbl_team_session')]
class TeamSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne(targetEntity: GameSession::class, inversedBy: 'teamSessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GameSession $gameSession = null;

    #[ORM\Column]
    private ?int $currentEnigmaOrder = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'in_progress';

    /**
     * @var Collection<int, TeamProgress>
     */
    #[ORM\OneToMany(targetEntity: TeamProgress::class, mappedBy: 'teamSession', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['timestamp' => 'ASC'])]
    private Collection $progress;

    public function __construct()
    {
        $this->progress = new ArrayCollection();
        $this->startedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getGameSession(): ?GameSession
    {
        return $this->gameSession;
    }

    public function setGameSession(?GameSession $gameSession): static
    {
        $this->gameSession = $gameSession;

        return $this;
    }

    public function getCurrentEnigmaOrder(): ?int
    {
        return $this->currentEnigmaOrder;
    }

    public function setCurrentEnigmaOrder(int $currentEnigmaOrder): static
    {
        $this->currentEnigmaOrder = $currentEnigmaOrder;

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
     * @return Collection<int, TeamProgress>
     */
    public function getProgress(): Collection
    {
        return $this->progress;
    }

    public function addProgress(TeamProgress $progress): static
    {
        if (!$this->progress->contains($progress)) {
            $this->progress->add($progress);
            $progress->setTeamSession($this);
        }

        return $this;
    }

    public function removeProgress(TeamProgress $progress): static
    {
        if ($this->progress->removeElement($progress)) {
            // set the owning side to null (unless already changed)
            if ($progress->getTeamSession() === $this) {
                $progress->setTeamSession(null);
            }
        }

        return $this;
    }
}
