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
                  <th>Conc</th>
                  <th>Pend.</th>
                  <th>Dt Init.</th>
                  <th>Dt Comp.</th>
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
                        <td>{{ date('d/m/Y H:i',strtotime($lote->created_at)) }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($lote->updated_at)) }}</td>
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
                              @if (auth()->user()->subtype == 0 || auth()->user()->subtype == 2)
                                <a class="dropdown-item"
                                    href="#"
                                    data-toggle="modal" data-target="#changeLotesDeTrabalho"
                                    data-status="{{ $listaMenor->first()->LOTE_ITEM_STATUS + 1 }}"
                                    data-href="{{ route('admin.lotes.changestatus',$lote->LOTE_TOKEN) }}">
                                    <div class="material-icons mr-3" style="width: 1.1rem;">change_circle</div> Alterar Status
                                </a>
                              @endif
                              <a class="dropdown-item"
                                  href="{{ route('admin.lotes.printer',$lote->LOTE_TOKEN) }}">
                                  <div class="material-icons mr-3" style="width: 1.1rem;">printer</div> Imprimir
                              </a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item btn-apagar" href="#"
                                  data-token="{{ $lote->LOTE_TOKEN }}"
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
<!-- Modal Alterar Status -->
<div class="modal fade" id="changeLotesDeTrabalho" tabindex="-1" role="dialog" aria-labelledby="changeLotesDeTrabalhoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeLotesDeTrabalhoLabel">Alterar Status do Lote</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Selecione o Status</label>
                <select class="form-control" data-style="btn btn-link" name="SETOR_FACCAO" required>
                  @foreach ($setores->sortBy('SETOR_ORDEM') as $setor)
                      <option value="{{$setor->SETOR_ORDEM}}">{{$setor->SETOR_NAME}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Alterar Status</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
    <script>
      $('#changeLotesDeTrabalho').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('form').attr('action',button.data('href'))
        modal.find('.modal-body select').val(button.data('status')).trigger('change')
      })
    </script>
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