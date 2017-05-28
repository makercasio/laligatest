<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity
 */
class Club
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity="Jugador", mappedBy="club")
     */

    private $jugadores;

    /**
     * @var bool
     *
     * @ORM\Column(name="borrado", type="boolean")
     */
    private $borrado;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->jugadores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Club
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Club
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Add Jugador.
     *
     * @param \BackendBundle\Entity\Jugador $jugadores
     *
     * @return void
     */
    public function addJugador(\BackendBundle\Entity\Jugador $jugador)
    {
        $jugador->setClub($this);
        $this->jugadores[] = $jugador;

        return $this;
    }

    /**
     * Add Jugador.
     *
     * @param \BackendBundle\Entity\Jugador $jugadores
     *
     * @return void
     */

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $jugadores
     * @return $this
     */
    public function setJugadores(\Doctrine\Common\Collections\ArrayCollection $jugadores)
    {
        $this->jugadores = $jugadores;

        return $this;
    }

    /**
     * @param Jugador $jugador
     * @return bool
     */

    public function removeJugadorClub(\BackendBundle\Entity\Jugador $jugador)
    {
        return $this->jugadores->removeElement($jugador);
    }


    /**
     * Return Jugadores in a club
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getJugadores()
    {
        return $this->jugadores;
    }

    /**
     * Set borrado
     *
     * @param boolean $borrado
     *
     * @return Club
     */
    public function setBorrado($borrado)
    {
        $this->borrado = $borrado;

        return $this;
    }

    /**
     * Get borrado
     *
     * @return bool
     */
    public function getBorrado()
    {
        return $this->borrado;
    }
}

