<?php

namespace App\Entity;

use App\Repository\MarquePageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarquePageRepository::class)]
class MarquePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_de_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\ManyToMany(targetEntity: MotsCles::class, mappedBy: 'liens')]
    private Collection $mot_cle;

    public function __construct()
    {
        $this->mot_cle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeInterface $date_de_creation): static
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }


    /**
     * @return Collection<int, MotsCles>
     */
    public function getMotCle(): Collection
    {
        return $this->mot_cle;
    }

    public function addMotCle(MotsCles $motCle): static
    {
        if (!$this->mot_cle->contains($motCle)) {
            $this->mot_cle->add($motCle);
            $motCle->addLien($this);
        }

        return $this;
    }

    public function removeMotCle(MotsCles $motCle): static
    {
        if ($this->mot_cle->removeElement($motCle)) {
            $motCle->removeLien($this);
        }

        return $this;
    }
}
