<?php

namespace App\Controller;

use App\Helper\EntidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ResponseFactory;
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
    protected $extratorDadosRequest;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ){
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function buscarTodos(Request $request): Response
    {
        $filtro = $this->extratorDadosRequest->buscarDadosFiltro($request);
        $informacoesDeOrdenacao = $this->extratorDadosRequest->buscarDadosOrdenacao($request);
        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscarDadosPaginacao($request);
        $lista = $this->repository->findBy(
            $filtro, 
            $informacoesDeOrdenacao,
            $itensPorPagina,
            ($paginaAtual - 1) * $itensPorPagina
        );
        $fabricaResposta = new ResponseFactory(
            true,
            $lista,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina,
        );
        return $fabricaResposta->getResponse();
    }

    public function buscarUm(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $statusResposta = is_null($entidade) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;
        $fabricaResposta = new ResponseFactory(
            true,
            $entidade,
            $statusResposta
        );

        return $fabricaResposta->getResponse();
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

    public function atualiza(int $id, Request $request): Response
    {

        $corpoRequisicao = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($corpoRequisicao);

        $entidadeExistente = $this->repository->find($id);
        if(is_null($entidadeExistente)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntidadeExistente($entidadeExistente, $entidadeEnviada);

        $this->entityManager->flush();

        return new JsonResponse($entidadeExistente);

    }

    abstract public function atualizarEntidadeExistente(
        $entidadeExistente, 
        $entidadeEnviada
    );

}