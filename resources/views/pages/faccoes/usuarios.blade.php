@extends('layouts.app', ['activePage' => 'faccoes', 'titlePage' => __('Usuários da Facção ' . $faccao->FAC_NAME)])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Usuários da Facção</h4>
                            <p class="card-category">Gerenciamento de Usuários</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editarNovoUsuario" data-type="0">Adicionar Usuário</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>
                                                Nome
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Data de Criação
                                            </th>
                                            <th class="text-right">
                                                Ação
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($usersFaccoes == "[]")
                                            <tr>
                                                <td>Sem Usuários</td>
                                                <td>Sem Usuários</td>
                                                <td>Sem Usuários</td>
                                                <td class="text-right">Sem Usuários</td>
                                            </tr>
                                        @else
                                            @foreach ($usersFaccoes as $relation)
                                                <tr>
                                                <td>
                                                    {{ $relation->user->name }}
                                                </td>
                                                <td>
                                                    {{ $relation->user->email }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y H:i', strtotime($relation->user->created_at)) }}
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a rel="tooltip" 
                                                    class="btn btn-success btn-link"
                                                    href="#"
                                                    data-toggle="modal" 
                                                    data-target="#editarNovoUsuario" 
                                                    data-type="1"
                                                    data-json="{{ json_encode($relation->user) }}"
                                                    data-original-title="" 
                                                    title="">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @if (auth()->user()->id != $relation->user->id)
                                                    <a rel="tooltip" 
                                                        class="btn btn-danger btn-link btn-apagar-user" 
                                                        href="#"
                                                        data-id="{{$relation->user->id}}"
                                                        data-original-title="" 
                                                        title="">
                                                        <i class="material-icons">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @endif
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
    {{-- Modal de Novo/Editar Usuário --}}
    <div class="modal fade" id="editarNovoUsuario" tabindex="-1" role="dialog" aria-labelledby="editarNovoUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarNovoUsuarioLabel">Adicionar Novo Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.faccoes.details.users.create', $faccao->FAC_TOKEN)}}" method="POST">
                  @csrf
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="inputName">Nome do usuário</label>
                        <input type="text" name="name" class="form-control" id="inputName">
                      </div>
                      <div class="form-group">
                        <label for="inputEmail">Endereço de Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail">
                      </div>
                      <div class="form-group">
                        <label for="inputPassword">Senha</label>
                        <input type="password" name="password" class="form-control" id="inputPassword">
                      </div>
                      <div class="form-group">
                        <label for="inputConfirmPassword">Confirmar Senha</label>
                        <input type="password" name="password_confirmation" class="form-control" id="inputConfirmPassword">
                      </div>
                      <span>
                        * A Senha deve conter pelo menos 8 caracteres * <br>
                        * Em caso de edição se não quiser alterar a senha deixe-a em branco! *
                      </span>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
      // Editar/Novo Usuário
      $('#editarNovoUsuario').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var type = button.data('type') // Extract info from data-* attributes
          var json = button.data('json') // Extract info from data-* attributes
          var urlNew = "{{route('admin.faccoes.details.users.create', $faccao->FAC_TOKEN)}}";
          var urlEdit = "{{route('admin.faccoes.details.users.update', [$faccao->FAC_TOKEN,'#'])}}";
          var modal = $(this)
          if(type){
            // Se for edição
            var title = "Editar Usuário";
            var url = urlEdit.replace('#',json.id);
            var inputs = modal.find('input');
            inputs[1].value = json.name;
            inputs[2].value = json.email;
          }else{
            // Se for novo
            var title = "Adicionar Novo Usuário";
            var url = urlNew;
          }
          modal.find('.modal-title').text(title);
          modal.find('form').attr('action',url);
      });
      // Apagar usuário
      (()=>{
        $('.btn-apagar-user').click((e)=>{
          Swal.fire({
            title: 'Deseja realmente apagar?',
            showDenyButton: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Apagar',
            denyButtonText: 'Não apagar',
          }).then((result) => {
            console.log(result);
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
              window.location.href = ("{{route('admin.faccoes.details.users.delete',[$faccao->FAC_TOKEN,'#'])}}").replace('#',$(e.currentTarget).data('id'));
            } else {
              Swal.fire('Ação cancelada!', '', 'info')
            }
          })
        });
      })();
    </script>
@endpush