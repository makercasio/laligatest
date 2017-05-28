<?php

namespace BackendBundle\Services\Liga\RepositoryServices;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use BackendBundle\Entity\Club;

class ClubRepositoryService
{

    private $em;
    private $logger;

    /**
     * ClubRepositoryService constructor.
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
     * @param Club $club
     * @return \Doctrine\Common\Collections\ArrayCollection
     */

    public function getJugadoresClub(Club $club) {
        return $club->getJugadores();
    }

    /**
     * @return array
     */
    public function getClubs() {
        $query = $this->em->createQuery('SELECT c FROM BackendBundle:Club c WHERE c.borrado != TRUE ORDER BY c.id DESC');
        $query->useQueryCache(true);

        return $query->getResult();
    }

    /**
     * @param Club $club
     * @return bool
     */
    public function createUpdateClub(Club $club) {
        $this->em->persist($club);
        $this->em->flush();
        return true;
    }

    /**
     * @param Club $club
     * @return bool
     */
    public function removeClub(Club $club) {
        $club->setBorrado(TRUE);
        $this->em->persist($club);
        $this->em->flush();
        return true;
    }

    /**
     * @param $id
     * @return mixed|null
     */

    public function findOneById($id)
    {
        $query = $this->em->createQuery('SELECT c FROM BackendBundle:Club c WHERE c.id = :id AND c.borrado != TRUE');
        $query->setParameter('id', $id);
        $query->useQueryCache(true);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            $this->logger->error('NoResultException, ClubRepositoryService '.$id);
            return null;
        }
    }
}
