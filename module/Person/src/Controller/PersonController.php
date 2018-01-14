<?php

declare(strict_types=1);

namespace Person\Controller;

use Person\Repository\PersonRepository;
use Person\Form\PersonForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

final class PersonController extends AbstractActionController
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var PersonForm
     */
    private $personForm;

    public function __construct(PersonRepository $personRepository, PersonForm $personForm)
    {
        $this->personRepository = $personRepository;
        $this->personForm = $personForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'persons' => $this->personRepository->findAll(),
        ]);
    }

    public function addAction()
    {
        $form = $this->personForm;

        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $person = $this->personRepository->createPersonFromFirstnameAndLastname(
                    $form->getData()['firstname'],
                    $form->getData()['lastname']
                );
                $this->personRepository->add($person);
                return $this->redirect()->toRoute('persons');
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }
}