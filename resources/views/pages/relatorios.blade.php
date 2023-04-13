@extends('layouts.app', ['activePage' => 'relatorios', 'titlePage' => __('Gerador de Relatórios')])

@php
    // dd($faccoes);
@endphp

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Relatórios</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <form action="{{ route('admin.relatorios.index') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                      <div class="mb-3">
                                        <label class="form-label">Data Inicial de Relatório</label>
                                        <input type="text" class="form-control date" name="DATE_INIT" placeholder="dd/mm/yyyy" required>
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-3">
                                        <label class="form-label">Data Final do Relatório</label>
                                        <input type="text" class="form-control date" name="DATE_END" placeholder="dd/mm/yyyy" required>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label>Referência de Data</label>
                                        <select class="form-control" name="FILTER_REF" required>
                                          <option value="created" selected>Data de Criação</option>
                                          <option value="updated">Data de Atualização</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-group">
                                        <label>Facções</label>
                                        <select class="form-control" name="FAC_FILTER" required>
                                          <option value="any" selected>Todas</option>
                                          @foreach ($faccoes as $facao)
                                          <option value="{{ $facao->FAC_TOKEN }}">{{ $facao->FAC_NAME }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <i class="material-icons">
                                          print
                                        </i>
                                        Gerar Relatório
                                      </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function() {
      $('.date').mask('00/00/0000');
    });
  </script>
@endpush
