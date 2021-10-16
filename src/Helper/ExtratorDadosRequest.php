<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscarDadosRequest(Request $request)
    {
        $informacoesDeOrdenacao = $request->query->get('sort');
        $informacoesDeFiltro = $request->query->all();
        unset($informacoesDeFiltro['sort']);

        return [$informacoesDeOrdenacao, $informacoesDeFiltro];
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
}