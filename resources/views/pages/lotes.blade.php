@extends('layouts.app', ['activePage' => 'lotes', 'titlePage' => __('Gerenciador de Lotes de Trabalho')])

@push('css')
    <style>
      .alert{
        padding: 5px 5px;
      }
    </style>
@endpush

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Lotes de Trabalho do Sistema</h4>
            <p class="card-category">Lista de Lotes de Trabalho do Sistema</p>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-12 text-right">
                  <a data-toggle="modal" data-target="#addLotesDeTrabalho"
                      class="btn btn-primary rounded-circle" style="color: white;padding: 1rem;">
                      <div class="material-icons">add</div>
                  </a>
                  {{-- <button  class="btn btn-sm btn-primary" type="button">Adicionar Lotes de Trabalho</button> --}}
                </div>
            </div>
            <div class="">
              <table class="table">
                <thead class=" text-primary">
                  <th>#</th>
                  <th>Facção</th>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th>Concluídos</th>
                  <th>Pendentes</th>
                  <th>Opções</th>
                </thead>
                <tbody>
                  @if ($lotes == "[]")
                    <tr>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                      <td>Sem Lotes</td>
                    </tr>
                  @else
                    @foreach ($lotes as $lote)
                      <tr>
                        <td>{{ $lote->id }}</td>
                        <td>{{ $lote->faccao->FAC_NAME }}</td>
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
                          @if ($lote->itens->groupBy('LOTE_ITEM_STATUS')->count() == 1 && $listaMaior->first()->LOTE_ITEM_STATUS == $setores->sortByDesc('SETOR_ORDEM')->first()->SETOR_ORDEM)
                              <div class="alert alert-success text-center" role="alert">
                                  Finalizado
                              </div>
                          @else
                              <div class="alert alert-warning text-center" role="alert">
                                  {{ $setores->sortBy('SETOR_ORDEM')->where("SETOR_ORDEM",$listaMenor->first()->LOTE_ITEM_STATUS)->first()->SETOR_NAME }}
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
                                  href="{{ route('admin.lotes.itens',$lote->LOTE_TOKEN) }}">
                                  <div class="material-icons mr-3" style="width: 1.1rem;">list</div> Ver Itens
                              </a>
                              <a class="dropdown-item"
                                  href="{{ route('admin.lotes.printer',$lote->LOTE_TOKEN) }}">
                                  <div class="material-icons mr-3" style="width: 1.1rem;">printer</div> Imprimir
                              </a>
                              <div class="dropdown-divider"></div>
                              {{-- <a class="dropdown-item" href="#"
                                  onclick="return false;">
                                  Bloquear
                              </a> --}}
                              <a class="dropdown-item" href="#"
                                  onclick="return false;">
                                  Apagar Lote
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
<div class="modal fade" id="addLotesDeTrabalho" tabindex="-1" role="dialog" aria-labelledby="addLotesDeTrabalhoLabel" aria-hidden="true">
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
            <div class="col-12">
              <div class="form-group">
                <label>Selecione uma facção</label>
                <select class="form-control" data-style="btn btn-link" name="FAC_ID" required>
                  @foreach ($faccoes as $faccao)
                      <option value="{{$faccao->id}}">{{$faccao->FAC_NAME}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Descrição Resumida do Lote</label>
                <input type="text" class="form-control" name="LOTE_DESC_SMALL" placeholder="Digite do lote" required>
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
                <input type="number" class="form-control" id="inputZip" min="1" max="1000" name="LOTE_QNT_ITENS" required>
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