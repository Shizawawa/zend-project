<?php
declare(strict_types=1);

namespace Person\Controller;

use Person\Repository\OrganizationRepository;
use Person\Form\OrganizationForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class OrganizationController extends AbstractActionController
{
    /**
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * @var OrganizationForm
     */
    private $organizationForm;

    public function __construct(OrganizationRepository $organizationRepository, OrganizationForm $organizationForm)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationForm = $organizationForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'organizations' => $this->organizationRepository->findAll(),
        ]);
    }

    public function addAction()
    {
        $form = $this->organizationForm;

        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $organization = $this->organizationRepository->createOrganizationFromName(
                    $form->getData()['name']
                );
                $this->organizationRepository->add($organization);
                return $this->redirect()->toRoute('organizations');
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }
}