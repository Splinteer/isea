<?php

namespace isea\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Demande
 */
class Demande
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \isea\AppBundle\Entity\Offre
     */
    private $offre;

    /**
     * @var string
     */
    private $cvPath;

    /**
     * @var string
     */
    private $lmPath;

     /**
     * @Assert\File(maxSize="6000000")
     */
    public $cv;
     /**
     * @Assert\File(maxSize="6000000")
     */
    public $lm;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Demande
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Demande
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Demande
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Demande
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set offre
     *
     * @param \isea\AppBundle\Entity\Offre $offre
     * @return Demande
     */
    public function setOffre(\isea\AppBundle\Entity\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \isea\AppBundle\Entity\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * Set cvPath
     *
     * @param string $cvPath
     * @return Demande
     */
    public function setCvPath($cvPath)
    {
        $this->cvPath = $cvPath;
    
        return $this;
    }

    /**
     * Get cvPath
     *
     * @return string 
     */
    public function getCvPath()
    {
        return $this->cvPath;
    }

    /**
     * Set lmPath
     *
     * @param string $lmPath
     * @return Demande
     */
    public function setLmPath($lmPath)
    {
        $this->lmPath = $lmPath;
    
        return $this;
    }

    /**
     * Get lmPath
     *
     * @return string 
     */
    public function getLmPath()
    {
        return $this->lmPath;
    }

    //CV
    public function getAbsolutePathCV()
    {
        return null === $this->cvPath ? null : $this->getUploadRootDir().'/'.$this->cvPath;
    }

    public function getWebPathCV()
    {
        return null === $this->cvPath ? null : 'http://' . $_SERVER['HTTP_HOST'] . '/isea/web/'  . $this->getUploadDir().'/'.$this->cvPath;
    }

    //LM
    public function getAbsolutePathLM()
    {
        return null === $this->lmPath ? null : $this->getUploadRootDir().'/'.$this->lmPath;
    }

    public function getWebPathLM()
    {
        return null === $this->lmPath ? null : 'http://' . $_SERVER['HTTP_HOST'] . '/isea/web/'  . $this->getUploadDir().'/'.$this->lmPath;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/demandes/';
    }

    public function uploadCV()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->cv) {
            return;
        }

        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        //$this->cv->move($this->getUploadRootDir(), $this->cv->getClientOriginalName());
        $name = uniqid('cv_', true) . '.' . $this->cv->guessExtension();
        $this->cv->move($this->getUploadRootDir(), $name);

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->cvPath = $name;

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->cv = null;
    }
    public function uploadLM()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->lm) {
            return;
        }

        $path_parts = pathinfo($this->lm);

        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        //$this->lm->move($this->getUploadRootDir(), $this->lm->getClientOriginalName());
        $name = uniqid('lm_', true) . '.' . $this->lm->guessExtension();
        $this->lm->move($this->getUploadRootDir(), $name);

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->lmPath = $name;

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->lm = null;
    }
}
