<?php

namespace isea\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use isea\AppBundle\Entity\Demande;
use isea\AppBundle\Entity\Offre;
use isea\AppBundle\Form\DemandeType;

/**
 * Demande controller.
 *
 */
class DemandeController extends Controller
{

    /**
     * Lists all Demande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('iseaAppBundle:Demande')->findAll();

        return $this->render('iseaAppBundle:Demande:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Demande entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Demande();

        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository('iseaAppBundle:Offre')->find($_POST['isea_appbundle_demande']['offre']);

        $form = $this->createCreateForm($entity, $offre);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $entity->uploadCV();
            $entity->uploadLM();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('isea_app_recrutement'));
        }
        return $this->redirect($this->generateUrl('isea_app_postuler', array('id' => $offre->getId(), 'key' => urlencode($offre->getLibelle()))));
    }

    /**
     * Creates a form to create a Demande entity.
     *
     * @param Demande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Demande $entity, Offre $offre)
    {
        $form = $this->createForm(new DemandeType(), $entity, array(
            'action' => $this->generateUrl('isea_app_demande_create'),
            'method' => 'POST',
        ));

        $form->add('offre', 'entity', array(
            'class' => 'iseaAppBundle:Offre',
            'label' => ' ',
            'data' => $offre,
            'attr' => array('class'=>"hidden")
        ));
        $form->add('cv', 'file', array('label'=>'CV'))
            ->add('lm', 'file', array('label'=>'Lettre de motivation'));
        $form->add('submit', 'submit', array('label' => 'Postuler', 'attr' => array('class' => 'button button-red')));

        return $form;
    }

    /**
     * Displays a form to create a new Demande entity.
     *
     */
    public function newAction()
    {
        $entity = new Demande();
        $form   = $this->createCreateForm($entity);

        return $this->render('iseaAppBundle:Demande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Demande entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la demande.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('iseaAppBundle:Demande:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Demande entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la demande.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('iseaAppBundle:Demande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Demande entity.
    *
    * @param Demande $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Demande $entity)
    {
        $form = $this->createForm(new DemandeType(), $entity, array(
            'action' => $this->generateUrl('backoffice_demande_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class' => 'button button-red')));

        return $form;
    }
    /**
     * Edits an existing Demande entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('iseaAppBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_demande_edit', array('id' => $id)));
        }

        return $this->render('iseaAppBundle:Demande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Demande entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('iseaAppBundle:Demande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Demande entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backoffice_demande'));
    }

    /**
     * Creates a form to delete a Demande entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backoffice_demande_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function postulerAction($id, $key)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository('iseaAppBundle:Offre')->find($id);

        $entity = new Demande();
        $form   = $this->createCreateForm($entity, $offre);

        return $this->render('iseaAppBundle:Default:recrutementForm.html.twig', array(
            'offre' => $offre,
            'form' => $form->createView(),
        ));
    }
}
