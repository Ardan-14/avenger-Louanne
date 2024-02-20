<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $anneeParution = null;

    #[ORM\Column]
    private ?int $nbPage = null;

    #[ORM\ManyToOne( inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auteur $auteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneeParution(): ?\DateTimeInterface
    {
        return $this->anneeParution;
    }

    public function setAnneeParution(\DateTimeInterface $anneeParution): static
    {
        $this->anneeParution = $anneeParution;

        return $this;
    }

    public function getNbPage(): ?int
    {
        return $this->nbPage;
    }

    public function setNbPage(int $nbPage): static
    {
        $this->nbPage = $nbPage;

        return $this;
    }

    public function getAuteur(): ?auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }


}
