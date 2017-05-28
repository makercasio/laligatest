<?php

namespace BackendBundle\Services\Liga\EntityServices;

use BackendBundle\Services\Liga\RepositoryServices\JugadorRepositoryService;
use BackendBundle\Services\Liga\RepositoryServices\ClubRepositoryService;
use BackendBundle\Entity\Jugador;

/**
 * Class JugadorService.
 */
class JugadorService
{

    private $em;
    private $clubRepositoryService;

    /**
     * JugadorService constructor.
     * @param JugadorRepositoryService $jugadorRepository
     * @param ClubRepositoryService $clubRepositoryService
     */

    public function __construct(JugadorRepositoryService $jugadorRepository, ClubRepositoryService $clubRepositoryService)
    {
        $this->em = $jugadorRepository;
        $this->clubRepositoryService = $clubRepositoryService;
    }

    /**
     * @return array
     */
    public function getJugadores() {
        return $this->em->getJugadores();
    }

    /**
     * @param Jugador $jugador
     * @return bool
     */
    public function createUpdateJugador($id = null, $nombre = null, $club = null) {

        if ((!empty($id) && !is_numeric($id)) || empty($nombre)) {
            return false;
        }

        $jugador = $id ? $this->em->findOneById($id) : new Jugador();

        if (empty($jugador)) {
            return false;
        }

        $jugador->setNombre($nombre);
        $jugador->setClub($club);

        return $this->em->createUpdateJugador($jugador);
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getJugador($id) {

        if (empty($id) || !is_numeric($id)) {
            return null;
        }

        return $this->em->findOneById($id);
    }

    /**
     * @param $club
     * @param array $excludeIds
     * @return bool
     */
    public function removeClubFromJugadores($club, $excludeIds = array()) {
        return $this->em->removeClubFromJugadores($club, $excludeIds);
    }


    /**
     * @param Jugador $jugador
     * @return bool
     */
    public function saveJugador(Jugador $jugador) {
        return $this->em->createUpdateJugador($jugador);
    }


    /**
     * @param Jugador $jugador
     * @return bool
     */
    public function removeJugador(Jugador $jugador) {
        return $jugador ? $this->em->removeJugador($jugador) : false;
    }
}
