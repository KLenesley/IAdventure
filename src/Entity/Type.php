<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ORM\Table(name: 'tbl_type')]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Enigma>
     */
    #[ORM\OneToMany(targetEntity: Enigma::class, mappedBy: 'type')]
    private Collection $enigmas;

    public function __construct()
    {
        $this->enigmas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Enigma>
     */
    public function getEnigmas(): Collection
    {
        return $this->enigmas;
    }

    public function addEnigma(Enigma $enigma): static
    {
        if (!$this->enigmas->contains($enigma)) {
            $this->enigmas->add($enigma);
            $enigma->setType($this);
        }

        return $this;
    }

    public function removeEnigma(Enigma $enigma): static
    {
        if ($this->enigmas->removeElement($enigma)) {
            // set the owning side to null (unless already changed)
            if ($enigma->getType() === $this) {
                $enigma->setType(null);
            }
        }

        return $this;
    }
}
