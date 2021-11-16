<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    private $sucesso;
    private $paginaAtual;
    private $statusResposta = Response::HTTP_OK;
    private $itensPorPagina;
    private $conteudoResposta;

    public function __construct(
        bool $sucesso,
        $conteudoResposta,
        int $statusResposta,
        int $paginaAtual = null,
        int $itensPorPagina = null
    )
    {
        $this->sucesso = $sucesso;
        $this->paginaAtual = $paginaAtual;
        $this->statusResposta = $statusResposta;
        $this->itensPorPagina = $itensPorPagina;
        $this->conteudoResposta = $conteudoResposta;
    }

    public function getResponse(): JsonResponse
    {
        $conteudoResposta = [
            'sucesso' => $this->sucesso,
            'paginaAtual' => $this->paginaAtual,
            'itensPorPagina' => $this->itensPorPagina,
            'conteudoResposta' => $this->conteudoResposta
        ];

        if(is_null($this->paginaAtual)){
            unset($conteudoResposta['paginaAtual']);
            unset($conteudoResposta['itensPorPagina']);
        }

        return new JsonResponse($conteudoResposta, $this->statusResposta);
    }
}