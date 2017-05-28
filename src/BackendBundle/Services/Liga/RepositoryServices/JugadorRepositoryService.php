<?php

namespace BackendBundle\Services\Liga\RepositoryServices;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use BackendBundle\Entity\Jugador;

/**
 * Class JugadorRepositoryService.
 */
class JugadorRepositoryService
{

    private $em;
    private $logger;

    /**
     * JugadorRepositoryService constructor.
     *
     * @param EntityManager        $em
     * @param DebugLoggerInterface $logger
     */
    public function __construct(EntityManager $em, DebugLoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getJugadores($hydrateArray = false) {
        $queryString = "SELECT j fROM BackendBundle:Jugador j ORDER BY j.id DESC";
        $query = $this->em->createQuery($queryString);

        $query->useQueryCache(true);

        return $hydrateArray ? $query->getArrayResult() : $query->getResult();
    }

    /**
     * @param $club
     * @param array $excludeIds
     * @return mixed
     */
    public function removeClubFromJugadores($club, $excludeIds = array()) {

        $queryString = "UPDATE BackendBundle:Jugador j SET j.club = NULL WHERE j.club = :club";

        if (!empty($excludeIds)) {
            $queryString .= " AND j.id NOT IN (:ids)";
        }

        $query = $this->em->createQuery($queryString);
        $query->setParameter('club', $club);

        if (!empty($excludeIds)) {
            $query->setParameter('ids', $excludeIds);
        }

        return $query->execute();
    }

    /**
     * @param Jugador $jugador
     * @return bool
     */
    public function createUpdateJugador(Jugador $jugador) {
        $this->em->persist($jugador);
        $this->em->flush();

        return true;
    }

    /**
     * @param Jugador $jugador
     * @return bool
     */
    public function removeJugador(Jugador $jugador) {
        $this->em->remove($jugador);
        $this->em->flush();

        return true;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function findOneById($id)
    {
        $query = $this->em->createQuery('SELECT j FROM BackendBundle:Jugador j WHERE j.id = :id');
        $query->setParameter('id', $id);
        $query->useQueryCache(true);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            $this->logger->error('NoResultException, JugadorRepositoryService '.$id);
            return null;
        }
    }
}
