@extends('layouts.app', ['activePage' => 'faccoes', 'titlePage' => __('Facção '.$faccao->FAC_NAME)])

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
      <div class="col-12">
        <button data-toggle="modal" data-target="#users" class="btn btn-primary" type="button">Ver Usuários da Facção</button>
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
                    <button data-toggle="modal" data-target="#addFaccao" class="btn btn-sm btn-primary" type="button">Adicionar Lote de Trabalho</button>
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