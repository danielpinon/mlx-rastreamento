@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Plurio SmartDocs')])

@push('css')
  <style>
    .page-header:before{
      background-color: white;
    }
    .page-header{
      color: #211D5A;
    }
    .login-page .container.content{
      height: auto;
      background-color: #211D5A;
      margin: unset !important;
      max-width: unset;
      flex-grow: unset;
      padding: 3rem 2rem;
    }
    .footer .container{
      background-color: white;
      color: #211D5A;
    }
    .nav-link{
      color: #211D5A;
      font-weight: 700;
    }
    .nav-item.active .nav-link::after{
      content: '';
      border-bottom: 3px solid #211D5A;
      width: 24px;
      display: block;
      margin: auto;
    }
    .btn.btn-primary,
    .btn.btn-primary:hover{
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      padding: 8px 16px;
      gap: 12px;
      width: 80%;
      height: 40px;
      background: #211D5A;
      border-radius: 50px;
      flex: none;
      order: 0;
      flex-grow: 1;
      box-shadow: none !important;
    }
  </style>
@endpush

@section('content')
<div class="container content" style="height: auto;">
  <div class="row align-items-center" style="padding-left: 1rem; padding-right: 1rem;">
    <div class="col-md-6 ml-auto mr-auto mb-3 text-center">
      <h1 style="color: white">
        Distribuidora Vitória 
      </h1>
    </div>
    <div class="col-md-5 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="card card-login card-hidden mb-3">
          <div class="card-body">
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <ul class="nav nav-pills" style="justify-content: center;">
                <li class="nav-item">
                  <a href="{{ route('login') }}" class="nav-link">
                    {{ __('Entrar') }}
                  </a>
                </li>
                <li class="nav-item active">
                  <a href="{{ route('register') }}" class="nav-link">
                    {{ __('Cadastre-se') }}
                  </a>
                </li>
              </ul>
            </div>
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="{{ __('Nome...') }}" value="{{ old('name') }}" required>
              </div>
              @if ($errors->has('name'))
                <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                  <strong>{{ $errors->first('name') }}</strong>
                </div>
              @endif
            </div>
            {{-- Escola --}}
            <div class="bmd-form-group{{ $errors->has('SCHOOLS_ID') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">school</i>
                  </span>
                </div>
                <select class="form-control" data-style="btn btn-link" name="SCHOOLS_ID" required>
                  <option value="null" selected disabled>Selecione uma escola...</option>
                  @foreach ($schools as $school)
                    <option value="{{$school->id}}" data-grade="{{json_encode($school->grades)}}">{{ $school->SCHOOL_NAME }}</option>
                  @endforeach
                </select>
              </div>
              @if ($errors->has('SCHOOLS_ID'))
                <div id="SCHOOLS_ID-error" class="error text-danger pl-3" for="SCHOOLS_ID" style="display: block;">
                  <strong>Esse campo é necessário</strong>
                </div>
              @endif
            </div>
            {{-- Série da Escola --}}
            <div class="bmd-form-group{{ $errors->has('GRADE_ID') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">school</i>
                  </span>
                </div>
                <select class="form-control" data-style="btn btn-link" name="GRADE_ID" required>
                  <option value="null" selected disabled>Selecione uma série...</option>
                </select>
              </div>
              @if ($errors->has('GRADE_ID'))
                <div id="GRADE_ID-error" class="error text-danger pl-3" for="GRADE_ID" style="display: block;">
                  <strong>Esse campo é necessário</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Senha...') }}" required>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmar Senha...') }}" required>
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>
            <div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="policy" name="policy" {{ old('policy', 1) ? '' : '' }} required>
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
                {{ __('Li e aceito a ') }} <a href="{{route('termodeuso')}}">{{ __('Termo de Uso') }}</a>
              </label>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Criar Conta') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
    <script>
      $('select[name="SCHOOLS_ID"]').on('change', function() {
        $('select[name="GRADE_ID"]').html('<option value="null" selected disabled>Selecione uma série...</option>');
        $(this).find(":selected").data('grade').forEach(e => {
          $('select[name="GRADE_ID"]').append('<option value="'+e.id+'">'+e.GRADE_NOME+'</option>');
        });
      });
    </script>
@endpush
