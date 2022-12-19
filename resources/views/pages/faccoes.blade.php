@extends('layouts.app', ['activePage' => 'faccoes', 'titlePage' => __('Gerenciador de Facções')])

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
            <h4 class="card-title ">Facções do Sistema</h4>
            <p class="card-category">Lista de Facções do Sistema</p>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-12 text-right">
                    <button data-toggle="modal" data-target="#addFaccao" class="btn btn-sm btn-primary" type="button">Adicionar Facção</button>
                </div>
            </div>
            <div class="">
              <table class="table">
                <thead class=" text-primary">
                  <th>#</th>
                  <th>Nome</th>
                  <th>Status</th>
                  <th>Qnt. Lotes</th>
                  <th>Pendentes</th>
                  <th>Opções</th>
                </thead>
                <tbody>
                  @if ($faccoes == "[]")
                    <tr>
                      <td>Sem Fações</td>
                      <td>Sem Fações</td>
                      <td>Sem Fações</td>
                      <td>Sem Fações</td>
                      <td>Sem Fações</td>
                      <td>Sem Fações</td>
                    </tr>
                  @else
                    @foreach ($faccoes as $faccao)
                      <tr>
                        <td>{{ $faccao->id }}</td>
                        <td>{{ $faccao->FAC_NAME }}</td>
                        <td>
                          @if ($faccao->FAC_STATUS)
                            <div class="alert alert-success text-center" role="alert">
                              Ativo
                            </div>
                          @else
                            <div class="alert alert-danger text-center" role="alert">
                              Desativado
                            </div>
                          @endif
                        </td>
                        <td>{{ $faccao->lotes->count() }}</td>
                        <td>{{ $faccao->lotes->where('LOTE_STATUS',true)->count() }}</td>
                        <td>
                          <button class="btn btn-primary dropdown-toggle p-2" type="button"
                              id="acoes" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              Ações
                          </button>
                          <div class="dropdown-menu" aria-labelledby="acoes">
                              <a class="dropdown-item"
                                  href="{{ route('admin.faccoes.info',$faccao->FAC_TOKEN) }}">
                                  Abrir Facção
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
<!-- Modal Adicionar Fação -->
<div class="modal fade" id="addFaccao" tabindex="-1" role="dialog" aria-labelledby="addFaccaoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFaccaoLabel">Adicionar Facção</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.faccoes.create') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Nome da Facção</label>
                <input type="text" class="form-control" name="FAC_NAME" placeholder="Digite o nome da facção">
              </div>
            </div>
            <div class="col-12">
              <label>Status da Facção</label>
              <div class="togglebutton">
                <label>
                  <input type="checkbox" checked="" name="FAC_STATUS">
                    <span class="toggle"></span>
                    Ativo
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Criar Facção</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection