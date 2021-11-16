<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscarDadosRequest(Request $request)
    {
        $queryString = $request->query->all();
        $dadosOrdenacao = array_key_exists('sort', $queryString)
            ? $queryString['sort']
            : [];
        unset($queryString['sort']);
        $paginaAtual = array_key_exists('page', $queryString)
            ? $queryString['page']
            : 1;
        unset($queryString['page']);
        $itensPorPagina = array_key_exists('itensPorPagina', $queryString)
            ? $queryString['itensPorPagina']
            : 5;
        unset($queryString['itensPorPagina']);

        return [$queryString, $dadosOrdenacao, $paginaAtual, $itensPorPagina];
    }

    public function buscarDadosOrdenacao(Request $request)
    {
        [$informacoesDeOrdenacao, ] = $this->buscarDadosRequest($request);

        return $informacoesDeOrdenacao;
    }

    public function buscarDadosFiltro(Request $request)
    {
        [, $informacoesDeFiltro] = $this->buscarDadosRequest($request);

        return $informacoesDeFiltro;
    }

    public function buscarDadosPaginacao(Request $request)
    {
        [ , ,$paginaAtual, $itensPorPagina] = $this->buscarDadosRequest($request);
        return [$paginaAtual, $itensPorPagina];
    }
}