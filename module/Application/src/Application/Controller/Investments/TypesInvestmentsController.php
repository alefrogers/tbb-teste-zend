<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Investments;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\StringLength;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Application\Model\InvestmentsType;
use DateTime;

class TypesInvestmentsController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        $multipleConditions = false;

        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $types = $em->getRepository("Application\Model\InvestmentsType")->createQueryBuilder('t');

        if (!empty($request->getQuery('date_start'))) {
            $dateAux = DateTime::createFromFormat('d/m/Y', $request->getQuery('date_start'));
            $types = $types->where('t.created_at >= :date_start')->setParameter('date_start', $dateAux->format('Y-m-d') . ' 00:00:00');
            $multipleConditions = true;
        }

        if (!empty($request->getQuery('date_end'))) {
            $dateAux = DateTime::createFromFormat('d/m/Y', $request->getQuery('date_end'));

            if ($multipleConditions) {
                $types = $types->andWhere('t.created_at <= :date_end')->setParameter('date_end', $dateAux->format('Y-m-d') . ' 00:00:00');
            } else {
                $types = $types->Where('t.created_at <= :date_end')->setParameter('date_end', $dateAux->format('Y-m-d') . ' 00:00:00');
            }
            $multipleConditions = true;
        }

        $types = $types->orderBy('t.id', 'ASC')->getQuery()->getResult();

        $view = new ViewModel(['result' => $types]);
        $view->setTemplate('investments/types/list');
        return $view;
    }

    public function createAction() {
        $view = new ViewModel();
        $view->setTemplate('investments/types/create');
        return $view;
    }

    function editAction() {
        $id = $this->params()->fromRoute("id");

        if (empty($id)) {
            $this->flashMessenger()->addErrorMessage("ID do editar não informado.");
            return $this->redirect()->toRoute('type-list');
        }

        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $type = $em->getRepository("Application\Model\InvestmentsType")->find($id);

        $view = new ViewModel(['result' => $type]);
        $view->setTemplate('investments/types/edit');
        return $view;
    }

    public function storageAction() {
        $request = $this->getRequest();

        ## Name ##
        $name = new Input('name');
        $name->getValidatorChain()->attach(new StringLength(array('min' => 4, 'max' => 120)));

        ## Profitability ##
        $profitability = new Input('profitability');
        $profitability->getValidatorChain()->attach(new IsFloat());

        ## Rate ##
        $rate = new Input('rate');
        $rate->getValidatorChain()->attach(new IsFloat());

        ## Application days ##
        $application_days = new Input('application_days');
        $application_days->getValidatorChain()->attach(new IsInt());

        $inputFilter = new InputFilter();
        $inputFilter->add($name);
        $inputFilter->add($profitability);
        $inputFilter->add($rate);
        $inputFilter->add($application_days);
        $inputFilter->setData($request->getPost());

        if ($inputFilter->isValid()) {
            try {
                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

                if (!empty($request->getPost('id'))) {
                    $model = $em->getRepository("Application\Model\InvestmentsType")->find($request->getPost('id'));
                } else {
                    $model = new InvestmentsType();
                }

                $model->setName($request->getPost('name'));
                $model->setProfitability($request->getPost('profitability'));
                $model->setRate($request->getPost('rate'));
                $model->setApplicationDays($request->getPost('application_days'));
                $model->setUpdatedAt(new dateTime());

                if (!empty($request->getPost('id'))) {
                    $this->flashMessenger()->addSuccessMessage('Registro atualizado com sucesso!');
                    $em->merge($model);
                } else {
                    $this->flashMessenger()->addSuccessMessage('Registro salvo com sucesso!');
                    $model->setCreatedAt(new dateTime());
                    $em->persist($model);
                }

                $em->flush();
            } catch (Exception $e) {
                $this->flashMessenger()->addErrorMessage("Erro ao salvar registro, tente novamente.");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("O registro não foi salvo, os dados fornecidos estão inválidos.");
        }

        return $this->redirect()->toRoute('type-list');
    }

    public function removeAction() {
        $id = $this->params()->fromRoute("id");
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $model = $em->getRepository("Application\Model\InvestmentsType")->find($id);

        if (empty($model)) {
            $this->flashMessenger()->addErrorMessage("Tipo de investimento não existente.");
            return $this->redirect()->toRoute('type-list');
        }

        if (count($model->getSimulations()) > 0) {
            $this->flashMessenger()->addErrorMessage("Registro não excluido, existe simulações para esse tipo de investimento.");
            return $this->redirect()->toRoute('type-list');
        }

        $em->remove($model);
        $em->flush();

        $this->flashMessenger()->addSuccessMessage("Registro excluido com sucesso.");
        return $this->redirect()->toRoute('type-list');
    }

}
