/*
|-------------------------------------------------------------------------------------------------------
| Global Formatting
|-------------------------------------------------------------------------------------------------------
*/

// $('.money').mask('#.##0,00', {reverse: true});
// $('.cpf').mask('000.000.000-00');
// $('.cnpj').mask('00.000.000/0000-00');
// $('.cod_re').mask('0000000', {reverse: true});


/*
|-------------------------------------------------------------------------------------------------------
| Main Functions
|-------------------------------------------------------------------------------------------------------
*/

function csrf_ajax(){
  $.ajaxSetup({
     headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
     }
  });
}

// Click on enter
function enter(obj){
  $(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        obj.click();
    }
  });
}

// Display Errors on AJAX Response
function display_errors(err){
  string = '<ul>';

  $.each(err, function(key, value){
    string += '<li>' + value + '</li>';
  });

  string += '</ul>';

  return string;
}

/*
|-------------------------------------------------------------------------------------------------------
| Data validation
|-------------------------------------------------------------------------------------------------------
*/

function validar_cpf(strCPF) {
  var Soma = 0;
  var Resto;

  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))  Resto = 0;
  if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
  for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
  Resto = (Soma * 10) % 11;

  if ((Resto == 10) || (Resto == 11))  Resto = 0;
  if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
  return true;
}

function validar_cnpj(cnpj) {
 
  cnpj = cnpj.replace(/[^\d]+/g,'');

  if(cnpj == '') return false;
   
  if (cnpj.length != 14)
      return false;

  // Elimina CNPJs invalidos conhecidos
  if (cnpj == "00000000000000" || 
      cnpj == "11111111111111" || 
      cnpj == "22222222222222" || 
      cnpj == "33333333333333" || 
      cnpj == "44444444444444" || 
      cnpj == "55555555555555" || 
      cnpj == "66666666666666" || 
      cnpj == "77777777777777" || 
      cnpj == "88888888888888" || 
      cnpj == "99999999999999")
      return false;
       
  // Valida DVs
  tamanho = cnpj.length - 2
  numeros = cnpj.substring(0,tamanho);
  digitos = cnpj.substring(tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
          pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(0))
      return false;
       
  tamanho = tamanho + 1;
  numeros = cnpj.substring(0,tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
          pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(1))
        return false;
         
  return true;
  
}

/*
|-------------------------------------------------------------------------------------------------------
| Objects
|-------------------------------------------------------------------------------------------------------
*/

function btn_ok(btn){
  btn.addClass('disabled').html("<i class='fa fa-check text-white'>");
}

function btn_disable(btn){
  btn.attr('disabled', 'true').html("<i class='fa fa-spinner fa-spin text-white'>");
}

function btn_enable(btn, btn_txt){
  btn.removeAttr("disabled").html(btn_txt);
}

/*
|-------------------------------------------------------------------------------------------------------
| External API's
|-------------------------------------------------------------------------------------------------------
*/

// API CEP Correio
function get_cep(cep, endereco, bairro, cidade, uf){

  cep_val = cep.val();

  if(cep_val.length == 9){
 
    cep_val = cep_val.replace('-','');

    $.getJSON("https://viacep.com.br/ws/" + cep_val + "/json/?callback=?", function(data){
      if(!("erro" in data)){
        endereco.val(data.logradouro);
        bairro.val(data.bairro);
        cidade.val(data.localidade);
        uf.val(data.uf);
      } else {
        swal("CEP Inválido", "Verifique o CEP informado e tente novamente.", "warning");
      }
    })

  } else {
    swal("CEP Inválido", "Verifique o CEP informado e tente novamente.", "warning");
  }

}

function setDatatable(table_obj, params = [false, true, true, true, false], emptyMsg = "Nenhum registro encontrado"){
  table_obj.width('100%');
  return table_obj.DataTable({
    responsive: true,
    ordering: params[0],
    bInfo: params[1],
    bFilter: params[2],
    bPaginate: params[3],
    bLengthChange: params[4],
    aLengthMenu: [[10,25,50,100,-1], [10,25,50,100,"Todos"]],
    oLanguage: {
      oPaginate: {
        sFirst: "Primeira",
        sLast: "Última",
        sNext: "Próxima",
        sPrevious: "Anterior"
      },
      sSearch: "Buscar",
      sEmptyTable: emptyMsg,
      sInfo: "Exibindo _START_ a _END_ de _TOTAL_ registros",
      sInfoEmpty: "Exibindo 0 a 0 de 0 registros",
      sInfoFiltered: "(filtrado do total de _MAX_ registros)",
      sLengthMenu: "Exibir _MENU_ registros"
    }
  });
}