<?php

namespace isea\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('iseaAppBundle:Article')->lastArticles();
        return $this->render('iseaAppBundle:Default:index.html.twig', array('articles' => $articles));
    }

    public function productsAction()
    {
        return $this->render('iseaAppBundle:Default:products.html.twig');
    }

    public function boutiqueAction()
    {
        return $this->render('iseaAppBundle:Default:boutique.html.twig');
    }

    public function documentsAction()
    {
        return $this->render('iseaAppBundle:Default:documents.html.twig');
    }

    public function articlesAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('iseaAppBundle:Article')->findAll();
        return $this->render('iseaAppBundle:Default:articles.html.twig', array('articles' => $articles));
    }

    public function articleAction($id, $key)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('iseaAppBundle:Article')->find($id);
        try {
            $article_prev = $em->getRepository('iseaAppBundle:Article')->articleBefore($id);
            }
        catch(\Doctrine\ORM\NoResultException $e) {
            $article_prev = false;
        }
        try {
            $article_suiv = $em->getRepository('iseaAppBundle:Article')->articleAfter($id);
            }
        catch(\Doctrine\ORM\NoResultException $e) {
            $article_suiv = false;
        }
        //echo urlencode($article->getTitre());
        return $this->render('iseaAppBundle:Default:article.html.twig', array(
            'article' => $article,
            'article_prev' => $article_prev,
            'article_suiv' => $article_suiv,
        ));
    }

    public function contactAction()
    {
        return $this->render('iseaAppBundle:Default:contact.html.twig', array('submit' => false));
    }

    public function contactsubmitAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom($_POST['mail'], $_POST['nom'])
            ->setTo('sanchezmarvin38@gmail.com')
            ->setBody($_POST['text']);
        $this->get('mailer')->send($message);
        return $this->render('iseaAppBundle:Default:contact.html.twig', array('submit' => true));
    }

    public function backofficeAction()
    {
        return $this->render('iseaAppBundle:Default:backoffice.html.twig', array('submit' => true));
    }
}
