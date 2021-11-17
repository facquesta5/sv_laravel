@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h4 class="float-start">Sistemas</h4>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-sistema-adicionar">
                <i class="fas fa-plus"></i> Novo Sistema</button>
            </div>
        </div>
    </div>
    <div class="panel-body p-3">
        <div class="row">
            <div class="col-md-12">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Sistema</th>
                            <th>Hospital</th>
                            <th class="text-center">Alterar</th>
                            <th class="text-center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sistemas as $sistema)
                        <tr class="text-center">
                            <td>{{ $sistema->nome }}</td>
                            <td>{{ $sistema->hospital }}</td>
                            <td class="text-center">
                                <i class="far fa-edit btn-alterar-sistema" data-target="#modal-sistema-alterar"
                                data-toggle="modal" data-hospital="{{ $sistema->id_hospital }}" id="{{ $sistema->id_sistema }}"></i>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-trash btn-excluir-sistema" id="{{ $sistema->id_sistema }}"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Adicionar Sistema --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-sistema-adicionar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Sistema</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Sistema</label>
                    <input class="form-control" type="text" id="nome">
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">State</label>
                    <select name="id_hospital" id="id_hospital"  class="form-select">
                        <option>--- Selecione um Hospital ---</option>
                        @foreach ($hospitais as $hospital)
                            <option id="{{$hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select> 
                    {{--  Form::select('hospital',['L' => 'Large', 'S' => 'Small'],null,['class'=>'form-select']); --}}
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


{{-- Modal de alterar Sistema --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-sistema-alterar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar Sistema</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Sistema</label>
                    <input class="form-control" type="text" id="nome-alt">
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
          <button type="button" class="btn btn-primary" id="btnAlterarSistema" data-id="">Salvar</button>
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
            url: 'sistemas/incluir',
            type: 'POST',
            data: {
                nome: $('#nome').val(),
                id_hospital: $('#id_hospital option:selected').attr('id'),
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
    }); /* END INCLUIR SISTEMA */


    $('#myTable tbody').on('click', '.btn-excluir-sistema', function() { /* START EXCLUIR SISTEMA */

        var idSistema = $(this).attr('id');

        Swal.fire({
            title: 'Você tem certeza?',
            text: "O sistema será excluído",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'sistemas/excluir',
                    type: 'DELETE',
                    data: {
                        id: idSistema,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Excluído!',
                            'O sistema foi excluído.',
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

    });/* END EXCLUIR SISTEMA */

    $('#myTable tbody').on('click', '.btn-alterar-sistema', function(){ /* START ALTERAR SISTEMA */

        var row = myTable.row($(this).closest('tr')).data();

        var idSistema = $(this).attr('id');

        var idHospital = $(this).attr('data-hospital');

        console.log(idHospital);

        $('#id_hospital-alt').val(idHospital);

        $('#btnAlterarSistema').attr('data-id', idSistema);

        $('#nome-alt').val(row[0]);
        
        let text = "";
    
    });

    $('#btnAlterarSistema').on('click', function(){/* START ALTERAR SISTEMA */

        var idSistema = $(this).attr('data-id');
        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);

        $.ajax({
            url: 'sistemas/alterar',
            type: 'PUT',
            data: {
                id: idSistema,
                id_hospital: $('#id_hospital-alt option:selected').attr('value'),
                nome: $('#nome-alt').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result){
                response = result;
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Os dados do sistema foram alterados',
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

    }); /* END ALTERAR SISTEMA */
    
});

</script>
@endsection