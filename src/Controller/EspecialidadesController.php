<?php

namespace App\Controller;

use App\Helper\EspecialidadeFactory;
use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends BaseController
{

    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $repository,
        EspecialidadeFactory $factory
    ) {
        parent::__construct($repository, $entityManager, $factory);
    }

    public function atualizarEntidadeExistente($entidadeExistente, $entidadeEnviada)
    {
        $entidadeExistente
            ->setDescricao($entidadeEnviada->getDescricao());
    }

}
