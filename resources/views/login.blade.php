@extends('template.initial')

@section('content')
<div class="container bg-light p-3 border rounded-3 mt-3" style="max-width:350px;">
    <div class="col-12 mt-1 ">
      <h6 for="" class="form-label">Entre com seu login de usuário</h6>
      <label for="exampleInputEmail1" class="form-label">Usuário</label>
      <input 
        type="text" 
        id="usuario"
        name="usuario"
        class="form-control"
        placeholder="Digite aqui o seu usuário"
        >
      <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="col-12">
      <label for="exampleInputPassword1" class="form-label">Senha</label>
      <input 
        type="password"
        id="senha"
        name="senha"
        class="form-control"
        placeholder="Digite aqui a sua senha"
        >
    </div>

    <div class="invalid-feedback">Usuário e/ou senha inválidos</div>
    
    <button id="loginUsuario" class="btn btn-primary mt-4">Entrar</button>
 
</div>
@endsection

@section('js');
<script type="text/javascript">

  $('document').ready(function (){

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('teste');
  
  $('#loginUsuario').on('click', function(){

    if ($('#usuario').val() == '' || $('#senha').val() == '') {
      } else {
          $.ajax({
              url: 'auth',
              type: 'POST',
              data: {
                  usuario: $('#usuario').val(),
                  senha: $('#senha').val()
              },
              success: function (result) {
                  if (result.status == 0) {
                      alert('Usuário e/ou senha incorreto');
                  } else {
                      window.open(result.status, '_self'); // Chama a rota 'home/admin ou home/cliente'
                  }
                  $('meta[name="csrf-token"]').attr('content', result.token);
              },
              error: function (result) {
                  console.log(result);
                  $('meta[name="csrf-token"]').attr('content', result.token);
              }
          });
      }
  });

        

  });

</script>
@endsection