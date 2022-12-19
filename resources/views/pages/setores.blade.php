@extends('layouts.app', ['activePage' => 'setores', 'titlePage' => __('Gerenciador de Setores')])

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
            <h4 class="card-title ">Stores do Sistema</h4>
            <p class="card-category">Lista de Setores do Sistema</p>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-12 text-right">
                    <button data-toggle="modal" data-target="#addSetor" class="btn btn-sm btn-primary" type="button">Adicionar Setor</button>
                </div>
            </div>
            <div class="">
              <table class="table" id="tableSetor">
                <thead class=" text-primary">
                  <th>Ordem</th>
                  <th>Nome</th>
                  <th class="text-center">Status</th>
                  <th class="text-right">Opções</th>
                </thead>
                <tbody>
                  @if ($setores == "[]")
                    <tr>
                      <td>Sem Setor</td>
                      <td>Sem Setor</td>
                      <td>Sem Setor</td>
                      <td>Sem Setor</td>
                    </tr>
                  @else
                    @foreach ($setores->sortBy('SETOR_ORDEM') as $setor)
                      <tr id="{{$setor->id}}">
                        <td>{{ $setor->SETOR_ORDEM }}</td>
                        <td>{{ $setor->SETOR_NAME }}</td>
                        <td class="text-center">
                          @if ($setor->SETOR_STATUS)
                            <div class="alert alert-success text-center" role="alert">
                              Ativo
                            </div>
                          @else
                            <div class="alert alert-danger text-center" role="alert">
                              Desativado
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
<div class="modal fade" id="addSetor" tabindex="-1" role="dialog" aria-labelledby="addSetorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSetorLabel">Adicionar Setor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.setores.create') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Nome do Setor</label>
                <input type="text" class="form-control" name="SETOR_NAME" placeholder="Digite o nome do setor">
              </div>
            </div>
            <div class="col-12">
              <label>Status do Setor</label>
              <div class="togglebutton">
                <label>
                  <input type="checkbox" checked="" name="SETOR_STATUS">
                    <span class="toggle"></span>
                    Ativo
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Criar Setor</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
    <script>
      $(document).ready(function() {
          $('#tableSetor tr:even').addClass('alt');
          $("#tableSetor").tableDnD({
              onDragClass: "myDragClass",
              onDrop: function(table, row) {
                  var rows = table.tBodies[0].rows;
                  var array = [];
                  for (var i=0; i<rows.length; i++) {
                      $($(rows[i]).find('td')[0]).html(i + 1);
                      array.push(rows[i].id);
                  }
                  console.log(array);
                  $.post("{{route('admin.setores.reorganiza')}}",{
                      _token:"{{csrf_token()}}",
                      lista:array
                  },(r)=>{});
              },
              onDragStart: function(table, row) {
                  //console.log("Started dragging row "+row.id);
              }
          });
      });
    </script>
@endpush