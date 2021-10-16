<?php

namespace App\Controller;

use App\Helper\EntidadeFactory;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends AbstractController
{

    protected $repository;
    protected $entityManager;
    protected $factory;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory
    ){
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    public function buscarTodos(): Response
    {
        $entityList = $this->repository->findAll();

        return new JsonResponse($entityList);
    }

    public function buscarUm(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }

    public function remove(int $id): Response
    {
        $entity = $this->repository->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function novo(Request $request): Response
    {
        $dadosRequest = $request->getContent();
        $entidade = $this->factory->criarEntidade($dadosRequest);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }

}