<?php

declare(strict_types=1);

namespace Rally\Controller;

use http\Exception;
use Rally\Entity\Meetup;
use Rally\Repository\MeetupRepository;
use Rally\Form\MeetupForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

final class IndexController extends AbstractActionController
{
    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    /**
     * @var MeetupForm
     */
    private $meetupForm;

    public function __construct(MeetupRepository $meetupRepository, MeetupForm $meetupForm)
    {
        $this->meetupRepository = $meetupRepository;
        $this->meetupForm = $meetupForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'meetups' => $this->meetupRepository->findAll(),
        ]);
    }

    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');

        try {
            $meetup = $this->meetupRepository->findMeetup($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('meetups');
        }

        return new ViewModel([
            'meetup' => $meetup,
        ]);
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        $form = $this->meetupForm;
        if (! $id) {
            return $this->redirect()->toRoute('meetups');
        }

        try {
            $meetup = $this->meetupRepository->findMeetup($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('meetups');
        }

        //$form->bind($meetup);
        $viewModel = new ViewModel(['form' => $form]);

        /* @var $request Request */
        $request = $this->getRequest();
        if (! $request->isPost()) {
            return $viewModel;
        }
        $data = $this->params()->fromPost();

        $form->setData($data);

        if (! $form->isValid()) {
            return $viewModel;
        }

        $data = $form->getData();

        try {
            $this->meetupRepository->updateMeetup($id, $data);
        } catch (Exception $exception){
            return $viewModel;
        }
        return $this->redirect()->toRoute(
        'meetups/detail', ['action' => 'detail', 'id' => $id]
        );
    }

    public function addAction()
    {
        $form = $this->meetupForm;

        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $meetup = $this->meetupRepository->createMeetupFromNameAndDescription(
                    $form->getData()['title'],
                    $form->getData()['description'] ?? '',
                    $form->getData()['dateBegin'],
                    $form->getData()['dateEnd']
                );
                $this->meetupRepository->add($meetup);
                return $this->redirect()->toRoute('meetups');
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if (! $id) {
            return $this->redirect()->toRoute('meetups');
        }

        try {
            $meetup = $this->meetupRepository->findMeetup($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('meetups');
        }

        /* @var $request Request */
        $request = $this->getRequest();
        if (! $request->isPost()) {
            return new ViewModel(['meetup' => $meetup]);
        }

        if ($id != $request->getPost('id')
            || 'Delete' !== $request->getPost('confirm', 'no')
        ) {
            return $this->redirect()->toRoute('meetups');
        }

        $this->meetupRepository->deleteMeetup($meetup);
        return $this->redirect()->toRoute('meetups');
    }
}
