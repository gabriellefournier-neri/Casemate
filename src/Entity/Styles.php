<?php

namespace App\Entity;

use App\Repository\StylesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StylesRepository::class)
 */
class Styles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Vinyle::class, mappedBy="Style")
     */
    private $vinyles;

    public function __construct()
    {
        $this->vinyles = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Vinyle[]
     */
    public function getVinyles(): Collection
    {
        return $this->vinyles;
    }

    public function addVinyle(Vinyle $vinyle): self
    {
        if (!$this->vinyles->contains($vinyle)) {
            $this->vinyles[] = $vinyle;
            $vinyle->setStyle($this);
        }

        return $this;
    }

    public function removeVinyle(Vinyle $vinyle): self
    {
        if ($this->vinyles->removeElement($vinyle)) {
            // set the owning side to null (unless already changed)
            if ($vinyle->getStyle() === $this) {
                $vinyle->setStyle(null);
            }
        }

        return $this;
    }
}
