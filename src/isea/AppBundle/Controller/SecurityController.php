<?php
namespace isea\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use isea\AppBundle\Entity\User;
use isea\AppBundle\Form\UserType;

class SecurityController extends Controller{
    public function loginAction () {
        $request = $this->getRequest();
        $session = $request->getSession();
        // récupérer les erreurs de login s'il y en a
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error= $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $entity = new User();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('iseaAppBundle:Security:login.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'last_username'=>$session->get(SecurityContext::LAST_USERNAME),'error'=>$error,
        ));
    }
    
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('isea_app_inscription'),
            'method' => 'POST',
            'public' => true,
        ));

        $form->add('submit', 'submit', array('label' => 'S\'inscrire'));

        return $form;
    }
    
    public function inscriptionAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $providerKey = 'vitrine_area'; // your firewall name
            $token = new UsernamePasswordToken($entity, null, $providerKey, $entity->getRoles());
            $this->container->get('security.context')->setToken($token);
            return $this->redirect($this->generateUrl('isea_app_profil'));
        }
        return $this->redirect($this->generateUrl('login'));
    }
}