<?php

namespace App\Controller;

use App\Helper\EspecialidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends BaseController
{

    public function __construct(
        EspecialidadeRepository $repository,
        EntityManagerInterface $entityManager,
        EspecialidadeFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct($repository, $entityManager, $factory, $extratorDadosRequest);
    }

    public function atualizarEntidadeExistente($entidadeExistente, $entidadeEnviada)
    {
        $entidadeExistente
            ->setDescricao($entidadeEnviada->getDescricao());
    }

}
