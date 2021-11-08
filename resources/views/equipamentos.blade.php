@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h4 class="float-start">Equipamentos</h4>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-equipamento-adicionar">
                <i class="fas fa-plus"></i> Novo Equipamento</button>
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
                            <th class="text-center">Alterar</th>
                            <th class="text-center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipamentos as $equipamento)
                        <tr class="text-center">
                            <td>{{ $equipamento->nome }}</td>
                            <td>{{ $equipamento->sistema }}</td>
                            <td>{{ $equipamento->hospital }}</td>
                            <td class="text-center">
                                <i class="far fa-edit btn-alterar-equipamento" data-target="#modal-equipamento-alterar"
                                data-toggle="modal" data-hospital="{{ $equipamento->id_hospital }}" 
                                data-sistema="{{ $equipamento->id_sistema }}" id="{{ $equipamento->id }}"></i>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-trash btn-excluir-equipamento" id="{{ $equipamento->id }}"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Adicionar Equipamento --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-equipamento-adicionar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Equipamento</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Equipamento</label>
                    <input class="form-control" type="text" id="nome">
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Sistema</label>
                    <select name="id_sistema" id="id_sistema"  class="form-select">
                        <option>--- Selecione um Sistema ---</option>
                        @foreach ($sistemas as $sistema)
                            <option id="{{$sistema->id }}">{{$sistema->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Hospital</label>
                    <select name="id_hospital" id="id_hospital"  class="form-select">
                        <option>--- Selecione um Hospital ---</option>
                        @foreach ($hospitais as $hospital)
                            <option id="{{$hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnNovoSistema">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

{{-- Modal de alterar Equipamento --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-equipamento-alterar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar Equipamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Equipamento</label>
                    <input class="form-control" type="text" id="nome-alt">
                </div>
                

                <div class="col-md-12">
                    <label for="" class="form-label">Sistema</label>
                    <select id="id_sistema-alt"  class="form-select">
                        @foreach ($sistemas as $sistema)
                            <option value="{{ $sistema->id }}">{{$sistema->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Hospital</label>
                    <select id="id_hospital-alt"  class="form-select">
                        @foreach ($hospitais as $hospital)
                            <option value="{{ $hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnAlterarEquipamento" data-id="">Salvar</button>
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

    $('#btnNovoSistema').on('click', function(){  /* START INCLUIR SISTEMA */

        let btn = $(this);
        let btn_text = btn.html();
        btn_disable(btn);

        $.ajax({
            url: 'equipamentos/incluir',
            type: 'POST',
            data: {
                nome: $('#nome').val(),
                id_hospital: $('#id_hospital option:selected').attr('id'),
                id_sistema: $('#id_sistema option:selected').attr('id'),
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
    }); /* END INCLUIR EQUIPAMENTO */

    
    $('#myTable tbody').on('click', '.btn-excluir-equipamento', function() { /* START EXCLUIR EQUIPAMENTO */

        var idEquipamento = $(this).attr('id');

        Swal.fire({
            title: 'Você tem certeza?',
            text: "O equipamento será excluído",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'equipamentos/excluir',
                    type: 'DELETE',
                    data: {
                        id: idEquipamento,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Excluído!',
                            'O equipamento foi excluído.',
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

    });/* END EXCLUIR EQUIPAMENTO */

    $('#myTable tbody').on('click', '.btn-alterar-equipamento', function(){ /* START ALTERAR EQUIPAMENTO */

        var row = myTable.row($(this).closest('tr')).data();
        var idEquipamento = $(this).attr('id');
        var idHospital = $(this).attr('data-hospital');
        var idSistema = $(this).attr('data-sistema');

        console.log(idHospital);

        $('#btnAlterarEquipamento').attr('data-id', idEquipamento);

        $('#nome-alt').val(row[0]);
        $('#id_hospital-alt').val(idHospital);
        $('#id_sistema-alt').val(idSistema);

        let text = "";

    });
    $('#btnAlterarEquipamento').on('click', function(){/* START ALTERAR EQUIPAMENTO */

        var idEquipamento = $(this).attr('data-id');
        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);

        $.ajax({
            url: 'equipamentos/alterar',
            type: 'PUT',
            data: {
                id: idEquipamento,
                id_hospital: $('#id_hospital-alt option:selected').attr('value'),
                id_sistema: $('#id_sistema-alt option:selected').attr('value'),
                nome: $('#nome-alt').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result){
                response = result;
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Os dados do Equipamento foram alterados',
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

    }); /* END ALTERAR EQUIPAMENTO */


});

</script>
@endsection