<?php

namespace isea\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 */
class Offre
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $resume;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Offre
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Offre
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    
        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $demandeOffre;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->demandeOffre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add demandeOffre
     *
     * @param \isea\AppBundle\Entity\Demande $demandeOffre
     * @return Offre
     */
    public function addDemandeOffre(\isea\AppBundle\Entity\Demande $demandeOffre)
    {
        $this->demandeOffre[] = $demandeOffre;
    
        return $this;
    }

    /**
     * Remove demandeOffre
     *
     * @param \isea\AppBundle\Entity\Demande $demandeOffre
     */
    public function removeDemandeOffre(\isea\AppBundle\Entity\Demande $demandeOffre)
    {
        $this->demandeOffre->removeElement($demandeOffre);
    }

    /**
     * Get demandeOffre
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDemandeOffre()
    {
        return $this->demandeOffre;
    }
}
