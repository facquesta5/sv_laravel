@extends('template.initial')

@section('content')
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" id="alert_box">
  <span  id="msg_alert"></span> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <strong aria-hidden="true">&times;</strong>
  </button>
</div>

<div class="container bg-light p-3 border rounded-3 mt-3" style="max-width:350px;">
<h5 for="" class="form-label mb-3">Entre com seu login de usuário</h5>  
  <div class="col-12 mt-1 ">
      
      <label for="exampleInputEmail1" class="form-label">Usuário</label>
      <input 
        type="text" 
        id="usuario"
        name="usuario"
        class="form-control"
        placeholder="Digite aqui o seu usuário"
        >
        <p class="" id="usuario-msg-alert"></p>
    </div>
    
    <div class="col-12 mt-2">
      <label for="exampleInputPassword1" class="form-label">Senha</label>
      <input 
        type="password"
        id="senha"
        name="senha"
        class="form-control"
        placeholder="Digite aqui a sua senha"
        >
        <p class="" id="senha-msg-alert"></p>
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

  
  $('#loginUsuario').click(function(){

    if ($("#usuario").val() == ''){
      let classes = ['alert-danger', 'msg-show'] ;
      $("#usuario").addClass(classes);
      let campo_usuario = 'Usuário é um campo obrigatório';
      $("#usuario-msg-alert").addClass('msg-danger').html(campo_usuario);
    }
    else if ($("#usuario").val() != ''){
      let classes = ['alert-danger', 'msg-show'] ;
      $("#usuario").removeClass(classes);
      let msg_classes = ['msg-danger', 'msg-show'] ;
      $("#usuario-msg-alert").removeClass(msg_classes).html(""); 
    }

    if ($("#senha").val() == ''){
      let classes = ['alert-danger', 'msg-show'] ;
      $("#senha").addClass(classes);
      let campo_senha = 'Senha é um campo obrigatório';
      $("#senha-msg-alert").addClass('msg-danger').html(campo_senha);
    }
    else if($("#senha").val() != ''){
      let classes = ['alert-danger', 'msg-show'] ;
      $("#senha").removeClass(classes);
      let msg_classes = ['msg-danger', 'msg-show'] ;
      $("#senha-msg-alert").removeClass(msg_classes).html("");

    }
  
    if($("#senha").val() != '' &&  ($("#usuario").val() != '')){
          $.ajax({
              url: 'auth',
              type: 'POST',
              data: {
                  usuario: $('#usuario').val(),
                  senha: $('#senha').val()
              },
              success: function (result) {
                  if (result == 0) {
                    console.log(result);

                    $('#alert_box').addClass('msg-show');
                    $('#msg_alert').html('Usuário ou senha não encontrados');


                  } else {
                    console.log(result);
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