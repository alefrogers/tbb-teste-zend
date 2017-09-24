<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbb_investments_type")
 */
class InvestmentsType {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;
    /**
     * @ORM\Column(type="float")
     */
    private $profitability;
    /**
     * @ORM\Column(type="float")
     */
    private $rate;
    /**
     * @ORM\Column(type="integer")
     */
    private $application_days;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;
    
     /**
     * @ORM\OneToMany(targetEntity="InvestmentsSimulations", mappedBy="types", cascade={"persist"})
     */
    private $simulations;

    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getProfitability() {
        return $this->profitability;
    }

    function getRate() {
        return $this->rate;
    }

    function getApplicationDays() {
        return $this->application_days;
    }

    function getCreatedAt() {
        return $this->created_at;
    }

    function getUpdatedAt() {
        return $this->updated_at;
    }
    
    function getSimulations() {
        return $this->simulations;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setProfitability($profitability) {
        $this->profitability = $profitability;
    }

    function setRate($rate) {
        $this->rate = $rate;
    }

    function setApplicationDays($application_days) {
        $this->application_days = $application_days;
    }

    function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }


}
