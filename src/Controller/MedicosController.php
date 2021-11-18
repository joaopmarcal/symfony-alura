<?php

namespace App\Controller;

use App\Helper\ExtratorDadosRequest;
use App\Helper\MedicoFactory;
use App\Repository\MedicosRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MedicosController extends BaseController
{

    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicosRepository $medicosRepository,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($medicosRepository, $entityManager,$medicoFactory, $extratorDadosRequest);
    }

    /**
     * @Route("/especialidades/{especialidadeId}/medicos", methods={"GET"})
     */
    public function buscaPorEspecialidade(int $especialidadeId): Response
    {

        $medicos = $this->repository->findBy([
            'especialidade' => $especialidadeId
        ]);

        return new JsonResponse($medicos);

    }

    public function atualizarEntidadeExistente(int $id, $entidade)
    {
        $entidadeExistente = $this->repository->find($id);
        if(is_null($entidadeExistente)){
            throw new \InvalidArgumentException();
        }
        $entidadeExistente
            ->setCrm($entidade->getCrm())
            ->setNome($entidade->getNome());

        return $entidadeExistente;

    }

}