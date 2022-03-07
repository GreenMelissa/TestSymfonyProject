<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\RequestType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RequestRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Контроллер для работы с заявками
 */
class RequestController extends AbstractController
{
    /**
     * @var FormInterface
     */
    private FormInterface $form;

    /**
     * Страница со списком заявок
     */
    #[Route('/request/index', name: 'index_request')]
    public function index(RequestRepository $requestRepository): Response
    {
        return $this->render('request/index.html.twig', ['requests' => $requestRepository->findAll()]);
    }

    /**
     * Создание заявки
     */
    #[Route('/request/create', name: 'create_request')]
    public function create(ManagerRegistry $doctrine, HttpRequest $httpRequest): Response
    {
        $entityManager = $doctrine->getManager();
        $request = new Request();
        $request->setUser($this->getUser());

        if ($this->processForm($entityManager, $httpRequest, $request)) {
            return $this->redirectToRoute('index_request');
        }

        return $this->renderForm('request/create.html.twig', [
            'form' => $this->form,
        ]);
    }

    /**
     * Редактирование заявки. Доступно только админу
     */
    #[Route('/request/update/{id}', name: 'update_request')]
    #[IsGranted('ROLE_ADMIN')]
    public function update(ManagerRegistry $doctrine, HttpRequest $httpRequest, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->flush();

        if ($this->processForm($entityManager, $httpRequest, $request)) {
            return $this->redirectToRoute('index_request');
        }

        return $this->renderForm('request/update.html.twig', [
            'form' => $this->form,
        ]);
    }

    /**
     * Обработка формы
     *
     * @param ObjectManager $entityManager
     * @param HttpRequest $httpRequest
     * @param Request $request
     * @return bool
     */
    private function processForm(ObjectManager $entityManager, HttpRequest $httpRequest, Request $request): bool
    {
        $this->form = $this->createForm(RequestType::class, $request);

        $this->form->handleRequest($httpRequest);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $request = $this->form->getData();
            $entityManager->persist($request);
            $entityManager->flush();
            return true;
        }

        return false;
    }
}
