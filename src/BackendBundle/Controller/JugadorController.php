<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Jugador;
use BackendBundle\Form\JugadorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JugadorController extends Controller
{
    /**
     * listing of Jugadores.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $jugadores = $this->get('liga.jugador.service')->getJugadores();

        $data = array(
            'contents' => $jugadores,
            'section' => 'Listado de jugadores',
        );

        return $this->render('BackendBundle:Jugador:index.html.twig', $data);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request) {

        $jugador = new Jugador();
        $form = $this->createForm(JugadorType::class, $jugador);

        $data = array(
            'content' => $jugador,
            'section' => 'Crear nuevo jugador',
            'form' => $form->createView(),
        );

        return $this->render('BackendBundle:Jugador:show.html.twig', $data);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request) {
        $jugador = new Jugador();
        $request = $this->get('request_stack')->getCurrentRequest();
        $form = $this->createForm(JugadorType::class, $jugador);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('liga.jugador.service')->saveJugador($jugador);
            $this->get('session')->getFlashBag()->add('success', 'El Jugador se creó correctamente !!');
            return $this->redirect($this->generateUrl('jugador_edit', array('id' => $jugador->getId())));
        }

        $this->get('session')->getFlashBag()->add('error', 'Por favor rellene los campos correctamente.');

        return $this->render('BackendBundle:Jugador:show.html.twig', array(
            'content' => $jugador,
            'section' => 'Crear nuevo jugador',
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

        $jugador = $this->get('liga.jugador.service')->getJugador($id);

        if (!$jugador) {
            throw new NotFoundHttpException($message);
        }

        $form = $this->createForm(JugadorType::class, $jugador);

        return $this->render('BackendBundle:Jugador:show.html.twig', array(
            'content' => $jugador,
            'section' => sprintf('Editar Jugador: %s', $jugador->getNombre()),
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $jugador = $this->get('liga.jugador.service')->getJugador($id);

        if (!$jugador) {
            return false;
        }

        $request = $this->get('request_stack')->getCurrentRequest();
        $form = $this->createForm(JugadorType::class, $jugador);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('liga.jugador.service')->saveJugador($jugador);
            $this->get('session')->getFlashBag()->add('success', 'El Jugador se editó correctamente.');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Por favor rellene los campos correctamente.');
        }

        return $this->redirect($this->generateUrl('jugador_edit', array('id' => $jugador->getId())));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $jugador = $this->get('liga.jugador.service')->getJugador($id);

        if ($this->get('liga.jugador.service')->removeJugador($jugador)) {
            $this->get('session')->getFlashBag()->add('success', 'El Jugador se borró correctamente.');
        }
        else {
            $this->get('session')->getFlashBag()->add('success', 'El Jugador no se pudo borrar.');
        }

        return $this->redirect($this->generateUrl('jugadores'));
    }
}
