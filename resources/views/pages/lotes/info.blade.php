@extends('layouts.app', ['activePage' => 'lotes', 'titlePage' => __('Lote ' . $lote->LOTE_DESC_SMALL)])

@push('css')
    <style>
        .alert {
            padding: 5px 5px;
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info</i>
                            </div>
                            <p class="card-category">Itens do Lote</p>
                            <h3 class="card-title">{{ $lote->LOTE_QNT_ITENS }}</h3>
                        </div>
                        <div class="card-footer">
                            {{ date('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info</i>
                            </div>
                            <p class="card-category">Facção</p>
                            <h3 class="card-title">{{ $lote->faccao->FAC_NAME }}</h3>
                        </div>
                        <div class="card-footer">
                            Responsável pelo Lote
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Itens do Lotes de Trabalho da Facção</h4>
                            <p class="card-category">Lista de Itens do Lote</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('admin.lotes.itens.add', $lote->LOTE_TOKEN) }}"
                                        class="btn btn-primary rounded-circle" style="color: white;padding: 1rem;">
                                        <div class="material-icons">add</div>
                                    </a>
                                </div>
                            </div>
                            <div class="">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>#</th>
                                        <th>Código de Barras</th>
                                        <th>Status/Etapa</th>
                                        <th>Opções</th>
                                    </thead>
                                    <tbody>
                                        @if ($lote->itens == '[]')
                                            <tr>
                                                <td>Sem Itens</td>
                                                <td>Sem Itens</td>
                                                <td>Sem Itens</td>
                                                <td>Sem Itens</td>
                                            </tr>
                                        @else
                                            @foreach ($lote->itens as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->LOTE_ITEM_IDENTIFY }}</td>
                                                    <td>
                                                        @if ($lote->LOTE_ITEM_STATUS)
                                                            <div class="alert alert-success text-center" role="alert">
                                                                Finalizado
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning text-center" role="alert">
                                                                Criado (Aguardando Entrar em Produção)
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <button class="btn btn-primary dropdown-toggle p-2" type="button"
                                                            id="acoes" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Ações
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="acoes">
                                                            <a class="dropdown-item" href="#" onclick="return false;">
                                                                Alterar Status
                                                            </a>
                                                            <a class="dropdown-item btn-apagar" href="#" data-id="{{ $item->id }}" onclick="return false;">
                                                                Apagar Item
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Apagar usuário
      (()=>{
        $('.btn-apagar').click((e)=>{
          Swal.fire({
            title: 'Deseja realmente apagar?',
            showDenyButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Apagar',
            denyButtonText: 'Não apagar',
          }).then((result) => {
            console.log(result);
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
              window.location.href = ("{{route('admin.lotes.itens.delete',[$lote->LOTE_TOKEN,'#'])}}").replace('#',$(e.currentTarget).data('id'));
            } else {
              Swal.fire('Ação cancelada!', '', 'info')
            }
          })
        });
      })();
    </script>
@endpush
