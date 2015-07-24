<?php

namespace isea\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use isea\AppBundle\Entity\Fidelite;
use isea\AppBundle\Form\FideliteType;

/**
 * Fidelite controller.
 *
 */
class FideliteController extends Controller
{

    /**
     * Lists all Fidelite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('iseaAppBundle:Fidelite')->findAll();

        return $this->render('iseaAppBundle:Fidelite:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Fidelite entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Fidelite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_fidelite_show', array('id' => $entity->getId())));
        }

        return $this->render('iseaAppBundle:Fidelite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function fideliteAction()
    {
        $entity = new Fidelite();
        $form   = $this->createCreateForm($entity, 2);

        return $this->render('iseaAppBundle:Fidelite:fidelite.html.twig', array(
            'form'   => $form->createView(),
            'submit' => false,
            'error' => false,
        ));
    }

    public function fidelitesubmitAction(Request $request)
    {
        /*$message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom($_POST['mail'], $_POST['nom'])
            ->setTo('sanchezmarvin38@gmail.com')
            ->setBody($_POST['text']);
        $this->get('mailer')->send($message);
        */
        $entity = new Fidelite();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('isea_app_boutique'));
        }else{
            return $this->render('iseaAppBundle:Fidelite:fidelite.html.twig', array(
                'form'   => $form->createView(),
                'submit' => false,
                'error' => 'Une erreur est intervenu, veillez réessayer',
            ));
        }
    }

    /**
     * Creates a form to create a Fidelite entity.
     *
     * @param Fidelite $entity The entity, $return 1=backoffice 2=boutique
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fidelite $entity, $return = 1)
    {
        $return = ($return ==1)? 'backoffice_fidelite_create' : 'isea_app_boutique';
        $form = $this->createForm(new FideliteType(), $entity, array(
            'action' => $this->generateUrl($return),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Participer', 'attr' => array('class' => 'button button-red')));

        return $form;
    }

    /**
     * Displays a form to create a new Fidelite entity.
     *
     */
    public function newAction()
    {
        $entity = new Fidelite();
        $form   = $this->createCreateForm($entity);

        return $this->render('iseaAppBundle:Fidelite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fidelite entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Fidelite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fidelite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('iseaAppBundle:Fidelite:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fidelite entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Fidelite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fidelite entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('iseaAppBundle:Fidelite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fidelite entity.
    *
    * @param Fidelite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fidelite $entity)
    {
        $form = $this->createForm(new FideliteType(), $entity, array(
            'action' => $this->generateUrl('backoffice_fidelite_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class' => 'button button-red', 'formnovalidate' => 'true')));

        return $form;
    }
    /**
     * Edits an existing Fidelite entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Fidelite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fidelite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_fidelite_edit', array('id' => $id)));
        }

        return $this->render('iseaAppBundle:Fidelite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fidelite entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('iseaAppBundle:Fidelite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fidelite entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backoffice_fidelite'));
    }

    /**
     * Creates a form to delete a Fidelite entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backoffice_fidelite_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class' => 'button button-red')))
            ->getForm()
        ;
    }
}
