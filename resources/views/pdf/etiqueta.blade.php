<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Código de Barras</title>
    <style>
        @page {
            margin: 5px 5px 5px 5px !important;
            padding: 0px 0px 0px 0px !important;
        }
        .description{
            font-size: .6rem;
            font-weight: bold;
        }
        .text{
            font-size: .5rem;
        }
    </style>
  </head>
  <body>
    <table>
        <tbody>
            <tr>
                <td class="text">Nome da Facção: {{ $lote->faccao->FAC_NAME }}</td>
                <td class="text">Data de Geração: {{ date('d/m/Y H:i:s',strtotime($lote->created_at)) }}</td>
            </tr>
            <tr>
                <td class="text">Desc. Resumida: {{  $lote->LOTE_DESC_SMALL }}</td>
                <td class="text">Qnt de Itens: {{  $lote->LOTE_QNT_ITENS }}</td>
            </tr>
            <tr>
                <td class="description" colspan="2">Descrição: {{  $lote->LOTE_BIG_DESC }}</td>
            </tr>
            <tr>
                <td class="text">Código: {{  $lote->LOTE_IDENTIFY }}</td>
            </tr>
            <tr>
                <td class="text" colspan="2"><img src="data:image/png;base64,{!! base64_encode($generator->getBarcode($lote->LOTE_IDENTIFY, $generator::TYPE_CODE_39)) !!}" style="width: 100%"></td>
            </tr>
        </tbody>
    </table>
  </body>
</html>