<div class="sidebar" data-color="purple">
  <div class="logo" style="min-height: 13rem;max-height: 13rem;">
    <a href="{{route('home')}}" class="simple-text logo-normal">
      <img src="{{ asset('material/img') }}/logo.png" alt="" width="50%">
    </a>
  </div>
  <div class="sidebar-wrapper" style="height: calc(100vh - 13rem);">
    <ul class="nav">
      {{-- Painel de Controle --}}
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Painel de Controle') }}</p>
        </a>
      </li>
      @if (auth()->user()->subtype == 0)
        {{-- Usuários do Sistema --}}
        <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
          <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
            <i class="material-icons">people</i>
            <p>{{ __('Usuários') }}
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse" id="laravelExample">
            <ul class="nav">
              <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                  <i class="material-icons">badge</i>
                  <span class="sidebar-normal">{{ __('Perfil de Usuário') }} </span>
                </a>
              </li>
              <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                  <i class="material-icons">group_add</i>
                  <span class="sidebar-normal"> {{ __('Gerenciador de Usuários') }} </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
      @endif
      @if (auth()->user()->subtype == 0 || auth()->user()->subtype == 2)
        {{-- Facção  --}}
        <li class="nav-item{{ $activePage == 'faccoes' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('admin.faccoes.index') }}">
            <i class="material-icons">content_paste</i>
              <p>{{ __('Ger. de Facções') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'setores' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('admin.setores.index') }}">
            <i class="material-icons">library_books</i>
              <p>{{ __('Ger. de Setores') }}</p>
          </a>
        </li>
        {{-- Relatórios do Sistema --}}
        <li class="nav-item{{ $activePage == 'relatorios' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('admin.relatorios.index') }}">
            <i class="material-icons">description</i>
            <p>{{ __('Ger. de Relatórios') }}</p>
          </a>
        </li>
      @endif
      <li class="nav-item{{ $activePage == 'lotes' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.lotes.index') }}">
          <i class="material-icons">work_history</i>
          <p>{{ __('Ger. de Lote de Trabalho') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
