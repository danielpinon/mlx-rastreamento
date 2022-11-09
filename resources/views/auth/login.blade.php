@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Plurio SmartDocs')])

@push('css')
    <style>
      .page-header:before{
        background-color: white;
      }
      .page-header{
        color: #072752;
      }
      .login-page .container.content{
        height: auto;
        background-color: #072752;
        margin: unset !important;
        max-width: unset;
        flex-grow: unset;
        padding: 3rem 2rem;
      }
      .footer .container{
        background-color: white;
        color: #072752;
      }
      .nav-link{
        color: #072752;
        font-weight: 700;
      }
      .nav-item.active .nav-link::after{
        content: '';
        border-bottom: 3px solid #072752;
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
        background: #072752;
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
      <img src="{{asset('material/img')}}/logo.png" alt="" width="50%">
    </div>
    <div class="col-md-5 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="card card-login card-hidden mb-3">
          <div class="card-body">
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <ul class="nav nav-pills" style="justify-content: center;">
                <li class="nav-item active">
                  <a href="{{ route('login') }}" class="nav-link">
                    {{ __('Entrar') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('register') }}" class="nav-link">
                    {{ __('Cadastre-se') }}
                  </a>
                </li>
              </ul>
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"> 
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email', '') }}" required>
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
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Senha...') }}" value="{{ !$errors->has('password') ? "" : "" }}" required>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Lembrar-me') }}
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
              </label>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg">{{ __('Entrar') }}</button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-light">
                    <small>{{ __('Esqueceu a senha?') }}</small>
                </a>
            @endif
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('register') }}" class="text-light">
                <small>{{ __('Criar nova Conta') }}</small>
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
