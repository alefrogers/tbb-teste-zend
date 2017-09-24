<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbb_investments_simulations_applications")
 */
class InvestmentsSimulationApplications {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

   
    /**
     * @ORM\Column(type="float")
     */
    private $val_application;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $date_application;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="InvestmentsSimulations", inversedBy="InvestmentsSimulationApplications, ")
     * @ORM\JoinColumn(name="id_simulation", referencedColumnName="id")
     */
    private $simulations;
    
    function getId() {
        return $this->id;
    }
     
    function getValApplication() {
        return $this->val_application;
    }

    function getDateApplication() {
        return $this->date_application;
    }
    
    function getCreatedAt() {
        return $this->created_at;
    }

    function getUpdatedAt() {
        return $this->updated_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    
    function setValApplication($val_application) {
        $this->val_application = $val_application;
    }

    function setDateApplication($date_application) {
       $this->date_application = $date_application;
    }

    function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
    
    function setSimulations($simulation){
        $this->simulations = $simulation;
    }

}
