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
use Application\Model\InvestmentsSimulations;
use Application\Model\InvestmentsSimulationApplications;
use DateTime;

class SimulationsInvestmentsController extends AbstractActionController {

    private function formFilter($post) {
        ## ID TYPE ##
        $id_type = new Input('id_type');
        $id_type->getValidatorChain()->attach(new IsInt());

        ## Items Json ##
        $items = new Input('json_items');
        $items->getValidatorChain()->attach(new StringLength(array('min' => 4)));

        $input_filter = new InputFilter();
        $input_filter->add($id_type);
        $input_filter->add($items);
        $input_filter->setData($post);

        return $input_filter;
    }

    public function indexAction() {
        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $simulations = $em->getRepository("Application\Model\InvestmentsSimulations")->createQueryBuilder('s');
        $multipleConditions = false;

        
        
        if (!empty($request->getQuery('id_type'))) {
            $simulations = $simulations
                    ->innerJoin('s.types', 'types')
                    ->where('types.id = :teste')->setParameter('teste', $request->getQuery('id_type'));
            $multipleConditions = true;
        }
        
        if (!empty($request->getQuery('date_start'))) {
            $dateAux = DateTime::createFromFormat('d/m/Y', $request->getQuery('date_start'));
            if ($multipleConditions) {
                $simulations = $simulations
                        ->andWhere('s.created_at >= :date_start')
                        ->setParameter('date_start', $dateAux->format('Y-m-d') . ' 00:00:00');
            } else {
                $simulations = $simulations
                        ->where('s.created_at >= :date_start')
                        ->setParameter('date_start', $dateAux->format('Y-m-d') . ' 00:00:00');
            }
            $multipleConditions = true;
        }

        if (!empty($request->getQuery('date_end'))) {
            $dateAux = DateTime::createFromFormat('d/m/Y', $request->getQuery('date_end'));

            if ($multipleConditions) {
                $simulations = $simulations->andWhere('s.created_at <= :date_end')->setParameter('date_end', $dateAux->format('Y-m-d') . ' 00:00:00');
            } else {
                $simulations = $simulations->Where('s.created_at <= :date_end')->setParameter('date_end', $dateAux->format('Y-m-d') . ' 00:00:00');
            }
            $multipleConditions = true;
        }

        $simulations = $simulations->orderBy('s.id', 'ASC')->getQuery()->getResult();

        $types = $em->getRepository("Application\Model\InvestmentsType")->findBy(array(), array('id' => 'ASC'));


        $view = new ViewModel(['types' => $types, 'result' => $simulations]);
        $view->setTemplate('investments/simulations/list');
        return $view;
    }

    public function createAction() {
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $types = $em->getRepository("Application\Model\InvestmentsType")->findAll();

        $view = new ViewModel(['types' => $types]);
        $view->setTemplate('investments/simulations/create');
        return $view;
    }

    function editAction() {
        $id = $this->params()->fromRoute("id");

        if (empty($id)) {
            $this->flashMessenger()->addErrorMessage("ID do editar não informado.");
            return $this->redirect()->toRoute('simulation-list');
        }

        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $result = $em->getRepository("Application\Model\InvestmentsSimulations")->find($id);
        $type = $em->getRepository("Application\Model\InvestmentsType")->findAll();

        $view = new ViewModel(['result' => $result, 'types' => $type]);
        $view->setTemplate('investments/simulations/edit');
        return $view;
    }

    public function insertAction() {
        $request = $this->getRequest();

        $input_filter = $this->formFilter($request->getPost());

        if ($input_filter->isValid()) {
            try {
                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                $json_items = json_decode($request->getPost('json_items'));
                $model = new InvestmentsSimulations();

                $model->setTypes($em->getRepository("Application\Model\InvestmentsType")->find($request->getPost('id_type')));
                $model->setCreatedAt(new dateTime());
                $model->setUpdatedAt(new dateTime());



                foreach ($json_items as $value) {
                    $value->val_application = str_replace(".", "", $value->val_application);
                    $value->date_application = DateTime::createFromFormat('d/m/Y', $value->date_application);

                    $aux = new InvestmentsSimulationApplications();
                    $aux->setValApplication(str_replace(",", ".", $value->val_application));
                    $aux->setDateApplication($value->date_application);
                    $aux->setCreatedAt(new dateTime());
                    $aux->setUpdatedAt(new dateTime());
                    $aux->setSimulations($model);

                    $model->addApplications($aux);
                }

                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Registro salvo com sucesso!');
            } catch (Exception $e) {
                $this->flashMessenger()->addErrorMessage("Erro ao salvar registro, tente novamente.");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("O registro não foi salvo, os dados fornecidos estão inválidos.");
        }

        return $this->redirect()->toRoute('simulation-list');
    }

    function updateAction() {
        $id = $this->params()->fromRoute("id");
        $request = $this->getRequest();

        $input_filter = $this->formFilter($request->getPost());

        if ($input_filter->isValid()) {
            try {
                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                $json_items = json_decode($request->getPost('json_items'));

                $model = $em->getRepository("Application\Model\InvestmentsSimulations")->find($id);
                $type = $em->getRepository("Application\Model\InvestmentsType")->find($request->getPost('id_type'));

                $model->setTypes($type);
                $model->setCreatedAt(new dateTime());
                $model->setUpdatedAt(new dateTime());


                $em->merge($model);
                $em->flush();

                foreach ($json_items as $value) {
                    $value->val_application = str_replace(".", "", $value->val_application);
                    $value->date_application = DateTime::createFromFormat('d/m/Y', $value->date_application);

                    if (empty($value->id)) {
                        $aux = new InvestmentsSimulationApplications();
                    } else {
                        $aux = $em->getRepository("Application\Model\InvestmentsSimulationApplications")->find($value->id);
                    }

                    $aux->setValApplication(str_replace(",", ".", $value->val_application));
                    $aux->setDateApplication($value->date_application);
                    $aux->setUpdatedAt(new dateTime());
                    $aux->setSimulations($model);

                    if (empty($value->id)) {
                        $aux->setCreatedAt(new dateTime());
                        $em->persist($aux);
                    } else {
                        $em->merge($aux);
                    }

                    $em->flush();
                }


                $this->flashMessenger()->addSuccessMessage('Registro atualizado com sucesso!');
            } catch (Exception $e) {
                $this->flashMessenger()->addErrorMessage("Erro ao atualizar registro, tente novamente.");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("O registro não foi salvo, os dados fornecidos estão inválidos.");
        }

        return $this->redirect()->toRoute('simulation-list');
    }

    public function removeAction() {
        $id = $this->params()->fromRoute("id");
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $model = $em->getRepository("Application\Model\InvestmentsSimulations")->find($id);

        if (empty($model)) {
            $this->flashMessenger()->addErrorMessage("Simulação não existente.");
            return $this->redirect()->toRoute('simulation-list');
        }

        foreach ($model->getApplications() as $value) {
            $em->remove($value);
        }

        $em->remove($model);
        $em->flush();

        $this->flashMessenger()->addSuccessMessage("Registro excluido com sucesso.");
        return $this->redirect()->toRoute('simulation-list');
    }

}
