<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Código de Barras</title>
    <style>
        @page {
            margin: 0px 0px 0px 5px !important;
            padding: 0px 0px 0px 0px !important;
        }
        .description{
            font-weight: bold;
        }
        .text{
            font-weight: bold;
        }
        tr,td{
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
    </style>
  </head>
  <body>
    <table>
        <tbody>
            <tr>
                <td class="text" width="60%">
                    <div style="font-size: 10pt;">Facção:  |  QNT:</div>
                    <div style="font-size: 10pt;">{{ $lote->faccao->FAC_NAME }} | {{  $lote->LOTE_QNT_ITENS }}</div>
                </td>
                <td class="text" width="40%" rowspan="3">
                    <img src="{!! $generator->render($lote->LOTE_IDENTIFY) !!}" alt="" width="100%">
                </td>
            </tr>
            <tr>
                <td class="text" width="60%">
                    <div style="font-size: 10pt;">Geração:</div>
                    <div style="font-size: 10pt;">{{ date('d/m/Y H:i:s',strtotime($lote->created_at)) }}</div>
                </td>
            </tr>
            <tr>
                <td class="description" colspan="2" style="font-size: 10pt;word-break: break-all;"  width="100%">
                    <div>Descrição: </div>
                    <div>{{  $lote->LOTE_BIG_DESC }}</div>
                </td>
            </tr>
            {{-- <tr>
                <td class="text" colspan="2">
                </td>
            </tr> --}}
        </tbody>
    </table>
  </body>
</html>