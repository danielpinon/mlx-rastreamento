@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Painel de Controle')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">reviews</i>
              </div>
              <p class="card-category">Msgs Pendentes</p>
              <h3 class="card-title">{{ $msgs->count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">description</i>
              </div>
              <p class="card-category">Total de Lotes</p>
              <h3 class="card-title">{{ $lotes->count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">history_edu</i>
              </div>
              <p class="card-category">Lotes Pendentes</p>
              <h3 class="card-title">{{ $lotes->where('LOTE_STATUS',false)->count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">work</i>
              </div>
              <p class="card-category">Facções</p>
              <h3 class="card-title">{{ $faccoes->count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Mensagens da Facção</h4>
              <p class="card-category">Mensagens recebidas.</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <th>Facção</th>
                  <th>Conteúdo</th>
                  <th class="text-right">Ações</th>
                </thead>
                <tbody>
                  @if ($msgs == "[]")
                    <tr>
                      <td>Sem Mensagens</td>
                      <td>Sem Mensagens</td>
                      <td class="text-right">Sem Mensagens</td>
                    </tr>
                  @else
                      @foreach ($msgs as $msg)
                        <tr>
                          <td>{{$msg->faccoes->FAC_NAME}}</td>
                          <td>{{$msg->FAC_MSG_APP}}</td>
                          <td class="text-right">
                            <a href="{{route('home.msg.read',$msg->id)}}" class="btn btn-primary"> <i class="material-icons">done</i> Marcar como lido</a>
                          </td>
                        </tr>                          
                      @endforeach
                  @endif
                  
                  {{-- <tr>
                    <td class="">Teste</td>
                    <td class="">Teste</td>
                    <td class="">Teste</td>
                    <td class="text-right">
                          <button class="btn btn-primary btn-sm">Abrir Alerta</button>
                          <button class="btn btn-primary btn-sm">Marcar como Resolvido</button>
                    </td>
                  </tr> --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush