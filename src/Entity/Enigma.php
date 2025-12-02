<?php

namespace App\Entity;

use App\Repository\EnigmaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnigmaRepository::class)]
#[ORM\Table(name: 'tbl_enigma')]
class Enigma
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $instruction = null;

    #[ORM\Column(length: 255)]
    private ?string $secretCode = null;

    #[ORM\Column(name: '`order`')]
    private ?int $order = null;

    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: 'enigmas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'enigmas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    /**
     * @var Collection<int, Thumbnail>
     */
    #[ORM\ManyToMany(targetEntity: Thumbnail::class)]
    #[ORM\JoinTable(name: 'tbl_enigma_thumbnail')]
    private Collection $thumbnails;

    public function __construct()
    {
        $this->thumbnails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(?string $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getSecretCode(): ?string
    {
        return $this->secretCode;
    }

    public function setSecretCode(string $secretCode): static
    {
        $this->secretCode = $secretCode;

        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(int $order): static
    {
        $this->order = $order;

        return $this;
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Thumbnail>
     */
    public function getThumbnails(): Collection
    {
        return $this->thumbnails;
    }

    public function addThumbnail(Thumbnail $thumbnail): static
    {
        if (!$this->thumbnails->contains($thumbnail)) {
            $this->thumbnails->add($thumbnail);
        }

        return $this;
    }

    public function removeThumbnail(Thumbnail $thumbnail): static
    {
        $this->thumbnails->removeElement($thumbnail);

        return $this;
    }
}
