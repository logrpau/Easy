<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TurnoRepository")
 */
class Turno
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="turnos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tienda", inversedBy="turnos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tienda;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     */
    private $hora_inicio;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     */
    private $hora_fin;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $comentario;

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function getIdTienda(): ?Tienda
    {
        return $this->id_tienda;
    }

    public function setIdTienda(?Tienda $id_tienda): self
    {
        $this->id_tienda = $id_tienda;

        return $this;
    }


    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHoraInicio(): ?\DateTimeInterface
    {
        return $this->hora_inicio;
    }

    public function setHoraInicio(\DateTimeInterface $hora_inicio): self
    {
        $this->hora_inicio = $hora_inicio;

        return $this;
    }

    public function getHoraFin(): ?\DateTimeInterface
    {
        return $this->hora_fin;
    }

    public function setHoraFin(\DateTimeInterface $hora_fin): self
    {
        $this->hora_fin = $hora_fin;

        return $this;
    }

    public function getFechaString(): ?String
    {
        return $this->fecha->format('d/m/Y');
    }

    public function getHoraInicioString(): ?String
    {

        return $this->hora_inicio->format('H:i');
    }

    public function getHoraFinString(): ?String
    {
        return $this->hora_fin->format('H:i');
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function toArray(): ?array
    {
        $tienda_nombre = $this->getIdTienda()->getNombreTienda();
        $usuario_nombre = $this->getIdUsuario()->getNombreCompleto();
        $titulo = 'Empleado: ' . $usuario_nombre . ' - Tienda: ' . $tienda_nombre;
        $hora_inicio = $this->getHoraInicio()->getTimestamp() + $this->getFecha()->getTimestamp() + 7200;
        $hora_fin = $this->getHoraFin()->getTimestamp() + $this->getFecha()->getTimestamp() + 7200;
        $id = $this->getId();
        
        return array('title' => $titulo, 'start' => $hora_inicio * 1000, 'end' => $hora_fin * 1000, 'id' => $id);
    }

}
