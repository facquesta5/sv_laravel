@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h2 class="float-start">Usuários</h2>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-usuario-adicionar">
                <i class="fas fa-plus"></i> Novo Usuário</button>
            </div>
        </div>
    </div>
    <div class="panel-body p-3">
        <div class="row">
            <div class="col-md-12">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Nome</th>
                            <th>email</th>
                            <th>Usuário</th>
                            <th>Alterar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr class="text-center">
                            <td>{{ $usuario->nome }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>
                                <i class="far fa-edit btn-alterar-usuario" data-target="#modal-usuario-alterar"
                                data-toggle="modal" id="{{ $usuario->id }}"></i>
                            </td>
                            <td>
                                <i class="fas fa-trash btn-excluir-usuario" id="{{ $usuario->id }}"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Adicionar Usuário --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-usuario-adicionar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Usuário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Nome</label>
                    <input class="form-control" type="text" id="nome">
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Email</label>
                    <input class="form-control" type="text" id="email">
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Usuário</label>
                    <input class="form-control" type="text" id="usuario">
                </div>
            </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Senha</label>
                    <input class="form-control" type="password" value="" id="senha">
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Confirme sua senha</label>
                    <input class="form-control" type="password" id="confirm_senha">
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnNovoUsuario">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>


{{-- Modal de alterar Usuário --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-usuario-alterar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar Usuário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Nome</label>
                    <input class="form-control" type="text" id="nome-alt">
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Email</label>
                    <input class="form-control" type="text" id="email-alt">
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Usuário</label>
                    <input class="form-control" type="text" id="usuario-alt">
                </div>
            </div>
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Senha</label>
                    <input class="form-control" type="text" value="" id="senha-alt">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnAlterarUsuario" data-id="">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')

<script>

$('document').ready(function() {

    var myTable = setDatatable($('#myTable'));

    /* 
    * * START INCLUIR USUARIO */
    $('#btnNovoUsuario').on('click', function(){  

        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);

        $.ajax({
            url: 'usuarios/incluir',
            type: 'POST',
            data: {
                nome: $('#nome').val(),
                email: $('#email').val(),
                usuario: $('#usuario').val(),
                senha: $('#senha').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result) {
                response = result;
                Swal.fire(
                    'Adicionado!',
                    response,
                    'success'
                );
                window.history.go(0);
                $('meta[name="csrf-token"]').attr('content',result.token);
                btn_enable(btn, btn_text);
                
            },
            error: function(result){
                console.log(result);
                $('meta[name="csrf-token"]').attr('content', result.token);
                btn_enable(btn, btn_text);
            }
        });
        btn_enable(btn, btn_text);
    }); /* END INCLUIR USUARIO */

   



    $('#myTable tbody').on('click', '.btn-excluir-usuario', function() { /* START EXCLUIR USUARIO */

        var idUsuario = $(this).attr('id');

        Swal.fire({
            title: 'Você tem certeza?',
            text: "O usuário será excluído",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'usuarios/excluir',
                    type: 'DELETE',
                    data: {
                        id: idUsuario,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Excluído!',
                            'O usuário foi excluído.',
                            'success'
                        );
                        $('meta[name="csrf-token"]').attr('content', result.token);
                        window.history.go(0);
                    },
                    error: function(result){
                        console.log(result);
                        $('meta[name="csrf-token"]').attr('content', result.token);
                    }
                });
            }
        });

    });/* END EXCLUIR USUARIO */


    $('#myTable tbody').on('click', '.btn-alterar-usuario', function(){ /* START ALTERAR USUARIO */

        var row = myTable.row($(this).closest('tr')).data();

        var idUsuario = $(this).attr('id');

        $('#btnAlterarUsuario').attr('data-id', idUsuario);

        $('#nome-alt').val(row[0]);

        $('#email-alt').val(row[1]);
        $('#usuario-alt').val(row[2]);

    });

    $('#btnAlterarUsuario').on('click', function(){/* START ALTERAR USUARIO */

        var idUsuario = $(this).attr('data-id');
        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);

        $.ajax({
            url: 'usuarios/alterar',
            type: 'PUT',
            data: {
                id: idUsuario,
                nome: $('#nome-alt').val(),
                email: $('#email-alt').val(),
                usuario: $('#usuario-alt').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result){
                response = result;
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Os dados do usuario foram alterados',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.go(0);
                    }
                });
                $('meta[name="csrf-token"]').attr('content', result.token);
                    btn_enable(btn, btn_text);
            },
            error: function(result){
                console.log(result);
                $('meta[name="csrf-token"]').attr('content', result.token);
                btn_enable(btn, btn_text);
            }

        });

    }); /* END ALTERAR USUARIO */



});
</script>
@endsection