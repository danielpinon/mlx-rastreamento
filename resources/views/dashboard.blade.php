@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Painel de Controle')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">notifications_active</i>
              </div>
              <p class="card-category">Nº de Alertas</p>
              <h3 class="card-title">3</h3>
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
              <h3 class="card-title">0</h3>
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
              <h3 class="card-title">0</h3>
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
              <h3 class="card-title">0</h3>
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
              <h4 class="card-title">Alertas</h4>
              <p class="card-category">Alertas Pendentes de Solução.</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <th>Origem</th>
                  <th>Conteúdo</th>
                  <th>Status</th>
                  <th class="text-right">Ações</th>
                </thead>
                <tbody>
                  <tr>
                    <td class="">Teste</td>
                    <td class="">Teste</td>
                    <td class="">Teste</td>
                    <td class="text-right">
                          <button class="btn btn-primary btn-sm">Abrir Alerta</button>
                          <button class="btn btn-primary btn-sm">Marcar como Resolvido</button>
                    </td>
                  </tr>
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