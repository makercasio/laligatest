<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Club;
use BackendBundle\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClubController extends Controller
{
    /**
     * listing of Clubs.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $clubs = $this->get('liga.club.service')->getClubs();

        $data = array(
            'contents' => $clubs,
            'section' => 'Listado de Clubs',
        );

        return $this->render('BackendBundle:Club:index.html.twig', $data);
    }
    
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request) {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);

        $data = array(
            'content' => $club,
            'section' => 'Crear nuevo club',
            'form' => $form->createView(),
        );

        return $this->render('BackendBundle:Club:show.html.twig', $data);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request) {
        $club = new Club();
        $request = $this->get('request_stack')->getCurrentRequest();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($club->getJugadores() as $jugador) {
                $club->setBorrado(FALSE);
                $jugador->setClub($club);
                $this->get('liga.jugador.service')->saveJugador($jugador);
            }

            $this->get('liga.club.service')->saveClub($club);
            $this->get('session')->getFlashBag()->add('success', 'El Club se creó correctamente !!');
            return $this->redirect($this->generateUrl('club_edit', array('id' => $club->getId())));
        }

        $this->get('session')->getFlashBag()->add('error', 'Por favor rellene los campos correctamente.');

        return $this->render('BackendBundle:Club:show.html.twig', array(
            'content' => $club,
            'section' => 'Crear nuevo club',
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id) {
        $message = 'No encontramos lo que que busca';

        if (empty($id) || !is_numeric($id)) {
            throw new NotFoundHttpException($message);
        }

        $club = $this->get('liga.club.service')->getClub($id);

        if (!$club) {
            throw new NotFoundHttpException($message);
        }

        $form = $this->createForm(ClubType::class, $club);

        return $this->render('BackendBundle:Club:show.html.twig', array(
            'content' => $club,
            'section' => sprintf('Editar Club: %s', $club->getNombre()),
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $club = $this->get('liga.club.service')->getClub($id);

        if (!$club) {
            return false;
        }

        $request = $this->get('request_stack')->getCurrentRequest();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $jugadorService = $this->get('liga.jugador.service');


            $excludeIds = array();
            foreach ($club->getJugadores() as $jugador) {
                $excludeIds[] = $jugador->getId();
                $jugador->setClub($club);
                $jugadorService->saveJugador($jugador);
            }

            $jugadorService->removeClubFromJugadores($club, $excludeIds);

            $this->get('liga.club.service')->saveClub($club);

            $this->get('session')->getFlashBag()->add('success', 'El Club se editó correctamente.');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Por favor rellene los campos correctamente.');
        }

        return $this->redirect($this->generateUrl('club_edit', array('id' => $club->getId())));
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $club = $this->get('liga.club.service')->getClub($id);

        if ($this->get('liga.club.service')->removeClub($club)) {
            $this->get('session')->getFlashBag()->add('success', 'El Club se borró correctamente.');
        }
        else {
            $this->get('session')->getFlashBag()->add('success', 'El Club no se pudo borrar.');
        }

        return $this->redirect($this->generateUrl('clubs'));
    }
}
