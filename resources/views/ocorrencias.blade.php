@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h4 class="float-start">Ocorrencias</h4>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-ocorrencia-adicionar">
                <i class="fas fa-plus"></i> Nova Ocorrencia</button>
            </div>
        </div>
    </div>
    <div class="panel-body p-3">
        <div class="row">
            <div class="col-md-12">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Equipamento</th>
                            <th>Sistema</th>
                            <th>Hospital</th>
                            <th>Ocorrencia</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Alterar</th>
                            <th class="text-center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($ocorrencias as $ocorrencia) 
                        <tr class="text-center">
                        <td>{{ $ocorrencia->equipamento }}</td>
                        <td>{{ $ocorrencia->sistema }}</td>
                        <td>{{ $ocorrencia->hospital }}</td>    
                        <td>{{ $ocorrencia->descricao }}</td>
                        
                        <th class="text-center">
                        @if( $ocorrencia->id_status == 3 )
                            <img width="16px" src="../images/vermelho.png" ></img>
                        @endif
                        @if( $ocorrencia->id_status == 2 )
                            <img width="16px" src="../images/amarelo.png" ></img>
                        @endif
                        @if( $ocorrencia->id_status == 1 )
                            <img width="16px" src="../images/verde.png" ></img>
                        @endif
                        </th>
                        
                            <td class="text-center">
                            <i class="far fa-edit btn-alterar-ocorrencia" data-target="#modal-ocorrencia-alterar"
                                data-toggle="modal"
                                data-equipamento="{{ $ocorrencia->id_equipamento }}" 
                                data-hospital="{{ $ocorrencia->id_hospital }}" 
                                data-sistema="{{ $ocorrencia->id_sistema }}"
                                data-status="{{ $ocorrencia->id_status }}" 
                                id="{{ $ocorrencia->id }}">
                            </i>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-trash btn-excluir-ocorrencia" id="{{ $ocorrencia->id }}"></i>
                            </td>
                        </tr>
                         @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Adicionar Ocorrencia --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-ocorrencia-adicionar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Ocorrencia</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Descrição da Ocorrência</label>
                    <textarea class="form-control" id="descricao"></textarea>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Hospital</label>
                    <select name="id_hospital" id="id_hospital" onChange="getEquipamentos()" class="form-select">
                        <option value=''>--- Selecione o Hospital ---</option>
                        @foreach ($hospitais as $hospital)
                            <option value="{{$hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Sistema</label>
                    <select name="id_sistema" id="id_sistema" onChange="getEquipamentos()" class="form-select">
                        <option value="">--- Selecione o Sistema ---</option>
                        @foreach ($sistemas as $sistema)
                            <option value="{{$sistema->id }}">{{$sistema->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label" >Equipamento</label>
                    <select name="id_equipamento" id="id_equipamento" disabled="disabled" class="form-select">
                        <option value="">--- Selecione o Equipamentos ---</option>
                    </select>
                </div>                
                <div class="col-md-12">
                    <label for="" class="form-label">Status de urgência</label>
                    <select name="id_status" id="id_status" class="form-select">
                        <option value="">--- Selecione o nível de urgência ---</option>
                        <option value="1">verde</option>
                        <option value="2">amarelo</option>
                        <option value="3">vermelho</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnNovoOcorrencia">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

{{-- Modal de alterar Ocorrencia --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-ocorrencia-alterar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar Ocorrencia</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Descrição da Ocorrência</label>
                    <textarea class="form-control" id="descricao-alt"></textarea>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Hospital</label>
                    <select name="id_hospital-alt" id="id_hospital-alt" onChange="getEquipamentos()" class="form-select">
                        <option value=''>--- Selecione um Hospital ---</option>
                        @foreach ($hospitais as $hospital)
                            <option value="{{$hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Sistema</label>
                    <select name="id_sistema-alt" id="id_sistema-alt" onChange="getEquipamentos()" class="form-select">
                        <option value="">--- Selecione um Sistema ---</option>
                        @foreach ($sistemas as $sistema)
                            <option value="{{$sistema->id }}">{{$sistema->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label" >Equipamento</label>
                    <select name="id_equipamento-alt" id="id_equipamento-alt" class="form-select">
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label" >Status de urgência</label>
                    <select name="id_status-alt" id="id_status-alt" class="form-select">
                        <option value="1" >verde</option>
                        <option value="2" >amarelo</option>
                        <option value="3" >vermelho</option>
                    </select>
                </div>  
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnAlterarOcorrencia" data-id="">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js')
<script>

$('document').ready(function(){

    var myTable = setDatatable($('#myTable'));

    /**
    * * START INCLUIR OCORRÊNCIA
    */ 
    $('#btnNovoOcorrencia').on('click', function(){

        let btn = $(this);
        let btn_text = btn.html();
        btn_disable(btn);

        $.ajax({
            url: 'ocorrencias/incluir',
            type: 'POST',
            data: {
                id_equipamento: $('#id_equipamento option:selected').attr('value'),
                id_sistema: $('#id_sistema option:selected').attr('value'),
                id_hospital: $('#id_hospital option:selected').attr('value'),
                id_status: $('#id_status option:selected').attr('value'),
                descricao: $('#descricao').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result) {
                response = result;
                console.log(result);
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

    });
    /**
    * * END INCLUIR OCORRENCIA 
    */

    /**
    * * START INCLUIR getEquipamentos
    */
    $("#id_hospital").on("change", function(){ getEquipamentos(); });
    $("#id_sistema").on("change", function(){ getEquipamentos(); });    
    
    function getEquipamentos(){
        
        if($('#id_hospital').val() != '' && $('#id_sistema').val() != ''){
            
            $.ajax({
                url: 'ocorrencias/listEquipamentos',
                type: 'POST',
                data: {
                    id_sistema: $('#id_sistema option:selected').val(),
                    id_hospital: $('#id_hospital option:selected').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(result){
                    console.log(result);
                    $('#id_equipamento').prop("disabled", true);
                    $('#id_equipamento').removeAttr("disabled");

                    var options = $('#id_equipamento');
                    options.find('option').remove();
                    
                    jQuery.each( result, function( key, value ) {
                        $( "#id_equipamento").append("<option value='"+ value.id +"'>"+ value.nome +"</option>");
                    });
                },
                error: function(result){
                    console.log(result);
                    $('meta[name="csrf-token"]').attr('content', result.token);
                    btn_enable(btn, btn_text);
                }
            });
        }
    }
    /**
    * * END INCLUIR getEquipamentos
    */
    
    /**
    * * START alterEquipamentos OCORRENCIA 
    */
    $("#id_hospital-alt").on("change", function(){ alterEquipamentos(); });
    $("#id_sistema-alt").on("change", function(){ alterEquipamentos(); }); 
    function alterEquipamentos(){
        
        if($('#id_hospital-alt').val() != '' && $('#id_sistema-alt').val() != ''){
            
            $.ajax({
                url: 'ocorrencias/listEquipamentos',
                type: 'POST',
                data: {
                    id_sistema: $('#id_sistema-alt option:selected').val(),
                    id_hospital: $('#id_hospital-alt option:selected').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(result){
                    console.log(result);
                    $('#id_equipamento-alt').prop("disabled", true);
                    $('#id_equipamento-alt').removeAttr("disabled");

                    var options = $('#id_equipamento-alt');
                    options.find('option').remove();
                    
                    jQuery.each( result, function( key, value ) {
                        $( "#id_equipamento-alt").append("<option value='"+ value.id +"'>"+ value.nome +"</option>");
                    });
                },
                error: function(result){
                    console.log(result);
                    $('meta[name="csrf-token"]').attr('content', result.token);
                    btn_enable(btn, btn_text);
                }
            });
        }
    }
    /**
    * * END alterEquipamentos OCORRENCIAS 
    */

    /**
    * * START ALTERAR OCORRENCIA 
    */
    $('#myTable tbody').on('click', '.btn-alterar-ocorrencia', function(){ 
        //ao clicar no botão de btn-alterar-ocorrencia
        var row = myTable.row($(this).closest('tr')).data();
        // a variavel row recebe os dados da linha formando um array de dados 
        var idOcorrencia = $(this).attr('id');
        // a variavel idOcorrencia recebe o valor setado no atributo id
        var idEquipamento = $(this).attr('data-equipamento');
        // a variavel idHospital recebe o valor setado no atributo data-hospital
        var idHospital = $(this).attr('data-hospital');
        // a variavel idHospital recebe o valor setado no atributo data-hospital
        var idSistema = $(this).attr('data-sistema');
        // a variavel idSistema recebe o valor setado no atributo data-sistema
        var idStatus = $(this).attr('data-status');
        // a variavel idStatus recebe o valor setado no atributo data-status
        console.log(idHospital);

        $('#descricao-alt').val(row[3]);
        $('#id_hospital-alt').val(idHospital);
        $('#id_sistema-alt').val(idSistema);
        $('#id_status-alt').val(idStatus);
        $('#btnAlterarOcorrencia').attr('data-id', idOcorrencia);

            $.ajax({
                url: 'ocorrencias/listEquipamentos',
                type: 'POST',
                data: {
                    id_sistema: idSistema,
                    id_hospital: idHospital,
                    _token: "{{ csrf_token() }}"
                },
                success: function(result){
                    console.log(result); 
                    
                    var options = $('#id_equipamento-alt');
                    options.find('option').remove();

                    jQuery.each( result, function( key, value ) {
                        $( "#id_equipamento-alt").append("<option value='"+ value.id +"'>"+ value.nome +"</option>");
                    });
                    
                    $('#id_equipamento-alt').val(idEquipamento);
                },
                error: function(result){
                    console.log(result);
                    $('meta[name="csrf-token"]').attr('content', result.token);
                    btn_enable(btn, btn_text);
                }
            });
    });

    $('#btnAlterarOcorrencia').on('click', function(){ 
        var idOcorrencia = $(this).attr('data-id');
        let btn = $(this);
        let btn_text = btn.html();
        btn_disable(btn); 
        Swal.fire({
            title: 'Você tem certeza?',
            text: "A ocorrencia será alterada",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, alterar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'ocorrencias/alterar',
                    type: 'PUT',
                    data: {
                        id: idOcorrencia,
                        id_equipamento: $('#id_equipamento-alt option:selected').attr('value'),
                        id_sistema: $('#id_sistema-alt option:selected').attr('value'),
                        id_hospital: $('#id_hospital-alt option:selected').attr('value'),
                        id_status: $('#id_status-alt option:selected').attr('value'),
                        descricao: $('#descricao-alt').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Alterado!',
                            'A ocorrência foi alterada',
                            'success'
                        );
                        $('meta[name="csrf-token"]').attr('content', result.token);
                        window.history.go(0);
                    },
                    error: function(result){
                        console.log(result);
                        $('meta[name="csrf-token"]').attr('content', result.token);
                        btn_enable(btn, btn_text);
                    }
                });   
            }
        });
    });
    /**
    * * END ALTERAR OCORRENCIA 
    */

    /**
    * * START EXCLUIR OCORRENCIA 
    */
    $('#myTable tbody').on('click', '.btn-excluir-ocorrencia', function() { 

        var idOcorrencia = $(this).attr('id');

        Swal.fire({
            title: 'Você tem certeza?',
            text: "A ocorrencia será excluída",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'ocorrencias/excluir',
                    type: 'DELETE',
                    data: {
                        id: idOcorrencia,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Excluído!',
                            'A ocorrência foi excluída.',
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

    });
    /**
    * * END EXCLUIR OCORRÊNCIA 
    */

});

</script>
@endsection