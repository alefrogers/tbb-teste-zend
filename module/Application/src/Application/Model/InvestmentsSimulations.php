<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Application\Model\InvestmentsType;
use Application\Model\InvestmentsSimulationApplications;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbb_investments_simulations")
 */
class InvestmentsSimulations {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="InvestmentsType", inversedBy="simulations")
     * @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     */
    private $types;

    /**
     * @ORM\OneToMany(targetEntity="InvestmentsSimulationApplications", mappedBy="simulations", cascade={"persist", "remove"})
     * @ORM\OrderBy({"date_application" = "ASC"})
     */
    private $applications;
    private $total_period;

    function getId() {
        return $this->id;
    }
    
    function getCreatedAt() {
        return $this->created_at;
    }

    function getUpdatedAt() {
        return $this->updated_at;
    }

    function getTypes() {
        return $this->types;
    }

    function getApplications() {
        return $this->applications;
    }

    function getTotalApplication() {
        $total = 0;

        foreach ($this->getApplications() as $value) {
            $total += $value->getValApplication();
        }

        return $total;
    }

    public function getTotalPeriodAttribute() {
        $first_application = $this->getApplications()[0];
        $total = $first_application->getDateApplication()->diff(new DateTime(date('Y-m-d')));
        $this->total_period = $total->format('%a');
        return $total->format('%a');
    }

    public function getIncomeAttribute($name) {
        $type = $this->types;
        $applications = $this->getApplications();

        switch ($name) {
            case 'client':
                $profitability_real = ($type->getProfitability() - $type->getRate()) / 100;
                break;
            case 'agency':
                $profitability_real = $type->getRate() / 100;
                break;
            case 'total':
                $profitability_real = $type->getProfitability() / 100;
                break;
        }

        return $this->calculeIncome($profitability_real, $type, $applications);
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function setTypes(InvestmentsType $type) {
        $this->types = $type;
    }

    function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function addApplications(InvestmentsSimulationApplications $application) {
        $this->applications[] = $application;

        return $this;
    }

    function calculeIncome($profitability_real, $type, $applications) {
        $days_income = 0;
        $value_income = 0;


        if (count($applications) > 1) {
            $valueApplication = 0;

            foreach ($applications as $key => $value) {
                $date_application = $value->getDateApplication();

                if (($key + 1) <= (count($applications) - 1)) {
                    $diff = $date_application->diff($applications[$key + 1]->getDateApplication());
                } else {
                    $diff = $date_application->diff(new DateTime(date('Y-m-d')));
                }

                $valueApplication += $value->getValApplication();

                $days_income = $diff->format('%a') / $type->getApplicationDays();
                $value_income += ($valueApplication * $profitability_real) * $days_income;
            }
        } else {
            $days_income = $this->total_period / $type->getApplicationDays();
            $value_income = ($this->getTotalApplication() * $profitability_real) * $days_income;
        }


        return $value_income;
    }

}
