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
            font-size: .6rem;
            font-weight: bold;
        }
    </style>
  </head>
  <body>
    <table>
        <tbody>
            <tr>
                <td class="text" width="50%">Nome da Facção: {{ $lote->faccao->FAC_NAME }}</td>
                <td class="text" width="50%">Data de Geração: {{ date('d/m/Y H:i:s',strtotime($lote->created_at)) }}</td>
            </tr>
            <tr>
                <td class="text" width="50%">Desc. Resumida: {{  $lote->LOTE_DESC_SMALL }}</td>
                <td class="text" width="50%">Qnt de Itens: {{  $lote->LOTE_QNT_ITENS }}</td>
            </tr>
            <tr>
                <td class="description" colspan="2">Descrição: {{  $lote->LOTE_BIG_DESC }}</td>
            </tr>
            <tr>
                <td class="text">Código: {{  $lote->LOTE_IDENTIFY }}</td>
            </tr>
            <tr>
                <td class="text" colspan="2"><img src="data:image/png;base64,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" style="width: 15%"></td>
            </tr>
        </tbody>
    </table>
  </body>
</html>