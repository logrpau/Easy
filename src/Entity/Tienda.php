<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TiendaRepository")
 */
class Tienda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nombre_tienda;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $calle_tienda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Turno", mappedBy="id_tienda")
     * 
     */
    private $turnos;

    public function __construct()
    {
        $this->turnos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreTienda(): ?string
    {
        return $this->nombre_tienda;
    }

    public function setNombreTienda(string $nombre_tienda): self
    {
        $this->nombre_tienda = $nombre_tienda;

        return $this;
    }

    public function getCalleTienda(): ?string
    {
        return $this->calle_tienda;
    }

    public function setCalleTienda(string $calle_tienda): self
    {
        $this->calle_tienda = $calle_tienda;

        return $this;
    }

    /**
     * @return Collection|Turno[]
     */
    public function getTurnos(): Collection
    {
        return $this->turnos;
    }

    public function addTurno(Turno $turno): self
    {
        if (!$this->turnos->contains($turno)) {
            $this->turnos[] = $turno;
            $turno->setIdTienda($this);
        }

        return $this;
    }

    public function removeTurno(Turno $turno): self
    {
        if ($this->turnos->contains($turno)) {
            $this->turnos->removeElement($turno);
            // set the owning side to null (unless already changed)
            if ($turno->getIdTienda() === $this) {
                $turno->setIdTienda(null);
            }
        }

        return $this;
    }
}
