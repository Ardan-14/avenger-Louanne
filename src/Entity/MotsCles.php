<?php

namespace App\Entity;

use App\Repository\MotsClesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotsClesRepository::class)]
class MotsCles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mot_cle = null;

    #[ORM\ManyToMany(targetEntity: MarquePage::class, inversedBy: 'mot_cle')]
    private Collection $liens;

    public function __construct()
    {
        $this->liens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotCle(): ?string
    {
        return $this->mot_cle;
    }

    public function setMotCle(string $mot_cle): static
    {
        $this->mot_cle = $mot_cle;

        return $this;
    }

    /**
     * @return Collection<int, MarquePage>
     */
    public function getLiens(): Collection
    {
        return $this->liens;
    }

    public function addLien(MarquePage $lien): static
    {
        if (!$this->liens->contains($lien)) {
            $this->liens->add($lien);
        }

        return $this;
    }

    public function removeLien(MarquePage $lien): static
    {
        $this->liens->removeElement($lien);

        return $this;
    }
}
