<?php

namespace BackendBundle\Services\Liga\EntityServices;

use BackendBundle\Entity\Club;
use BackendBundle\Services\Liga\RepositoryServices\ClubRepositoryService;
use BackendBundle\Services\Liga\RepositoryServices\JugadorRepositoryService;
use Doctrine\ORM\NoResultException;

/**
 * Class ClubService.
 */
class ClubService
{

    private $em;
    private $jugadorRepository;

    /**
     * ClubService constructor.
     * @param ClubRepositoryService $clubRepository
     * @param JugadorRepositoryService $jugadorRepository
     */
    public function __construct(ClubRepositoryService $clubRepository, JugadorRepositoryService $jugadorRepository)
    {
        $this->em = $clubRepository;
        $this->jugadorRepository = $jugadorRepository;
    }

    /**
     * @param Club $club
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getJugadoresClub(Club $club) {
        return $this->em->getJugadores($club);
    }

    /**
     * @return array
     */
    public function getClubs() {
        return $this->em->getClubs();
    }

    /**
     * @param $id
     * @param $nombre
     * @param string $telefono
     * @param array $jugadores
     * @return bool
     */
    public function createUpdateClub($id, $nombre, $telefono = '', $jugadores = array()) {

        if ((!empty($id) && !is_numeric($id)) || empty($nombre)) {
            return false;
        }

        $club = $id ? $this->em->findOneById($id) : new Club();

        $club->setNombre($nombre);
        $club->setTelefono($telefono);
        $club->setJugadores($jugadores);
        $club->setBorrado(FALSE);

        return $this->em->createUpdateClub($club);
    }

    /**
     * @param Club $club
     * @return bool
     */
    public function removeClub(Club $club) {
        return $this->em->removeClub($club);
    }


    /**
     * @param $id
     * @return mixed|null
     */
    public function getClub($id) {
        if (empty($id) || !is_numeric($id)) {
            return null;
        }

        return $this->em->findOneById($id);
    }

    /**
     * @param Club $club
     * @return bool
     */
    public function saveClub(Club $club) {
        $club->setBorrado(FALSE);
        return $this->em->createUpdateClub($club);
    }
}
