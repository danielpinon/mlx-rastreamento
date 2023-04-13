<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Lotes</title>
    <style>
        {{file_get_contents(public_path('material/css/material-print.css'))}}
    </style>
    <style>
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        }
        .card-header.card-header-primary{
            background-color: #1F2338 !important;
        }
        .card-title, .card-category {
            color: white !important;
        }
        body {
            background: rgb(204,204,204); 
        }
        page {
            background: white;
            background-size:100% 100%;
            background-size:cover;
            background-position: center;
            background-repeat: no-repeat;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        page[size="A4"] {  
            padding-top: 2rem;
            padding-bottom: 2rem;
            width: 21cm;
            /*height: 29.7cm;*/
            page-break-after: always; 
            page-break-inside: avoid;
        }
        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;  
        }
        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }
        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;  
        }
        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }
        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;  
        }
        @media print {
            body, page {
                margin: 0;
                box-shadow: unset;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <page size="A4" class="pr-4 pl-4">
        <center>
            <img src="{{ "data:image/png;base64,".base64_encode(file_get_contents(public_path('material/img/logo.png')))}}" width="100px">
        </center>
        <h4 class="text-center mt-2">RELATÓRIO DE LOTES</h4>
        <p class="mt-4">
            DATA FILTRO: {{$request->DATE_INIT}} a {{$request->DATE_END}}<br />
            DATA E HORA DE GERACAO: {{date('d/m/Y H:i')}} <br />
            QUANTIDADE TOTAL DE LOTES: {{$lotes->count()}}<br />
        </p>
        @if ($lotes == "[]")
            <center style="margin-top:10rem">Sem Lotes no Periodo Filtrado</center>
        </page>
        @else
            @foreach ($lotes->groupBy('FAC_ID') as $faccao)
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ $faccao[0]->faccao->FAC_NAME }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr class="">
                                            <th class="text-uppercase">Lote</th>
                                            <th class="text-uppercase">Etapa</th>
                                            <th class="text-uppercase">Criação</th>
                                            <th class="text-uppercase">ULT Atual.</th>
                                            <th class="text-uppercase">QUANT.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faccao as $lote)
                                            <tr>
                                                <td>{{ $lote->LOTE_DESC_SMALL }}</td>
                                                <td>
                                                    @php
                                                        $maior = 0;
                                                        $menor = 0;
                                                        $listaMaior = null;
                                                        $listaMenor = null;
                                                        foreach ($lote->itens->groupBy('LOTE_ITEM_STATUS') as $itensLote) {
                                                            if ($maior < $itensLote->count()) {
                                                            $maior = $itensLote->count();
                                                            $listaMaior = $itensLote;
                                                            }
                                                            if ($menor == 0 || $itensLote->count() <= $menor) {
                                                            $menor = $itensLote->count();
                                                            $listaMenor = $itensLote;
                                                            }
                                                        }
                                                    @endphp
                                                    @if ($lote->itens->groupBy('LOTE_ITEM_STATUS')->count() == 1 && $listaMaior->first()->LOTE_ITEM_STATUS + 1 == $setores->sortByDesc('SETOR_ORDEM')->first()->SETOR_ORDEM)
                                                        <img src="{{ "data:image/png;base64,".base64_encode(file_get_contents(public_path('material/img/verified.png')))}}" width="25px">
                                                        {{ $setores->sortBy('SETOR_ORDEM')->where("SETOR_ORDEM",$listaMenor->first()->LOTE_ITEM_STATUS + 1)->first()->SETOR_NAME }}
                                                    @else
                                                        <img src="{{ "data:image/png;base64,".base64_encode(file_get_contents(public_path('material/img/pending.png')))}}" width="25px">
                                                        {{ $setores->sortBy('SETOR_ORDEM')->where("SETOR_ORDEM",$listaMenor->first()->LOTE_ITEM_STATUS + 1)->first()->SETOR_NAME }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/Y h:i',strtotime($lote->created_at)) }}</td>
                                                <td>{{ date('d/m/Y h:i',strtotime($lote->updated_at)) }}</td>
                                                <td>{{ $lote->LOTE_QNT_ITENS }}</td>
                                            </tr>
                                            @php
                                                // dd($lote);
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach 
            </page>
        @endif
</body>
</html>