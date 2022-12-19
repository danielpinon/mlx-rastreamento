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
                                <button data-toggle="modal" data-target="#users" class="btn btn-primary" type="button">Ver
                                    Usuários da Facção</button>
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
                            <h3 class="card-title">0</h3>
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
                                    <a href="{{ route('admin.faccoes.details.lotedetrabalho.new', $faccao->FAC_TOKEN) }}" class="btn btn-primary rounded-circle"
                                        style="color: white;padding: 1rem;">
                                        <div class="material-icons">add</div>
                                    </a>
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
                                  @if ($faccao->lotes == "[]")
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
                                          @if ($lote->LOTE_STATUS)
                                            <div class="alert alert-success text-center" role="alert">
                                              Finalizado
                                            </div>
                                          @else
                                            <div class="alert alert-warning text-center" role="alert">
                                              Criado / Em Produção
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
                                                  Ver Itens
                                              </a>
                                              <div class="dropdown-divider"></div>
                                              {{-- <a class="dropdown-item" href="#"
                                                  onclick="return false;">
                                                  Bloquear
                                              </a> --}}
                                              <a class="dropdown-item" href="#"
                                                  onclick="return false;">
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
@endsection
