@extends('layouts.app', ['activePage' => 'faccoes', 'titlePage' => __('Facção ' . $faccao->FAC_NAME)])

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
                <div class="col-lg-9 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="row" style="text-align: start">
                                        <div class="col-12">
                                            <h5 style="font-weight: bold">EMPRESA: {{ $faccao->FAC_NAME }}</h5>
                                        </div>
                                        <div class="col-12">
                                            <h6>STATUS: @if ($faccao->FAC_STATUS == true)
                                                    <div class="alert alert-success text-center p-0 m-0" role="alert">
                                                        Ativo
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning text-center p-0 m-0" role="alert">
                                                        Bloqueado
                                                    </div>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <a href="{{ route('admin.faccoes.details.users', $faccao->FAC_TOKEN) }}"
                                        class="btn btn-primary">Ver
                                        Usuários da Facção</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info</i>
                            </div>
                            <p class="card-category">Lotes de Trabalho Total</p>
                            <h3 class="card-title">{{ $faccao->lotes->count() }}</h3>
                        </div>
                        <div class="card-footer">
                            {{ date('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Lotes de Trabalho da Facção</h4>
                            <p class="card-category">Lista de Lotes de Trabalho</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button data-toggle="modal" data-target="#addLotesDeTrabalho"
                                        class="btn btn-primary rounded-circle" style="color: white;padding: 1rem;">
                                        <div class="material-icons">add</div>
                                    </button>
                                    {{-- <button data-toggle="modal" data-target="#addFaccao" class="btn btn-sm btn-primary"
                                        type="button">Adicionar Lote de Trabalho</button> --}}
                                </div>
                            </div>
                            <div class="">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>#</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Concluídos</th>
                                        <th>Pendentes</th>
                                        <th>Opções</th>
                                    </thead>
                                    <tbody>
                                        @if ($faccao->lotes == '[]')
                                            <tr>
                                                <td>Sem Lotes</td>
                                                <td>Sem Lotes</td>
                                                <td>Sem Lotes</td>
                                                <td>Sem Lotes</td>
                                                <td>Sem Lotes</td>
                                                <td>Sem Lotes</td>
                                            </tr>
                                        @else
                                            @foreach ($faccao->lotes as $lote)
                                                <tr>
                                                    <td>{{ $lote->id }}</td>
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
                                                            <div class="alert alert-success text-center" role="alert">
                                                                {{ $setores->sortBy('SETOR_ORDEM')->where("SETOR_ORDEM",$listaMenor->first()->LOTE_ITEM_STATUS + 1)->first()->SETOR_NAME }}
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning text-center" role="alert">
                                                                {{ $setores->sortBy('SETOR_ORDEM')->where("SETOR_ORDEM",$listaMenor->first()->LOTE_ITEM_STATUS + 1)->first()->SETOR_NAME }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $lote->itens->count() }}</td>
                                                    <td>{{ $lote->itens->count() }}</td>
                                                    <td>
                                                        <button class="btn btn-primary dropdown-toggle p-2" type="button"
                                                            id="acoes" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Ações
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="acoes">
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.lotes.itens', $lote->LOTE_TOKEN) }}">
                                                                Ver Itens
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item btn-apagar" href="#"
                                                                data-token="{{ $lote->LOTE_TOKEN }}">
                                                                Apagar
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

    <!-- Modal Adicionar Fação -->
    <div class="modal fade" id="addLotesDeTrabalho" tabindex="-1" role="dialog" aria-labelledby="addLotesDeTrabalhoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLotesDeTrabalhoLabel">Adicionar Lote</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.lotes.create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="FAC_ID" value="{{ $faccao->id }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Descrição Resumida do Lote</label>
                                    <input type="text" class="form-control" name="LOTE_DESC_SMALL"
                                        placeholder="Digite do lote" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Descrição Completa do Lote</label>
                                    <textarea class="form-control" rows="3" name="LOTE_BIG_DESC"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ml-auto">
                                    <label for="inputZip">Quantidade de Itens</label>
                                    <input type="number" class="form-control" id="inputZip" min="1"
                                        max="1000" name="LOTE_QNT_ITENS" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Criar Lote</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        // Apagar Documento
        (() => {
            $('.btn-apagar').click((e) => {
                Swal.fire({
                    title: 'Deseja realmente apagar o lote?',
                    showDenyButton: true,
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Apagar',
                    denyButtonText: 'Não apagar',
                }).then((result) => {
                    console.log(result);
                    /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        window.location.href = (
                            "{{ route('admin.lotes.apagar', '#') }}"
                        ).replace('#', $(e.currentTarget).data('token'));
                    } else {
                        Swal.fire('Ação cancelada!', '', 'info')
                    }
                })
            });
        })();
    </script>
@endpush
