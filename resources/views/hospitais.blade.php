@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h2 class="float-start">Hospitais</h2>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-hospital-adicionar">
                <i class="fas fa-plus"></i> Novo Hospital</button>
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
                            <th class="text-center">Alterar</th>
                            <th class="text-center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($hospitais as $hospital) 
                        <tr class="text-center">
                            <td>{{ $hospital->nome }}</td>
                            <td class="text-center">
                                <i class="far fa-edit btn-alterar-hospital" data-target="#modal-hospital-alterar"
                                data-toggle="modal" id="{{ $hospital->id }}"></i>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-trash btn-excluir-hospital" id="{{ $hospital->id }}"></i>
                            </td>
                        </tr>
                         @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Modal de Adicionar Hospital --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-hospital-adicionar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Hospital</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Nome</label>
                    <input class="form-control" type="text" id="nome">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnNovoHospital">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>


{{-- Modal de alterar Hospital --}}
<div class="modal" tabindex="-1" role="dialog" id="modal-hospital-alterar">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alterar Hospital</h5>
          <i class="fas fa-times close"  data-dismiss="modal" aria-label="Close"></i>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label class="font-weight-bold" for="">Nome</label>
                    <input class="form-control" type="text" id="nome-alt">
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnAlterarHospital" data-id="">Salvar</button>
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

    $('#btnNovoHospital').on('click', function(){/* START INCLUIR USUARIO */
        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);
            
        $.ajax({
            url: 'hospitais/incluir',
            type: 'POST',
            data: {
                nome: $('#nome').val(),
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
    }); /* END INCLUIR HOSPITAL */

    $('#myTable tbody').on('click', '.btn-excluir-hospital', function() { /* START EXCLUIR HOSPITAL */

        var idHospital = $(this).attr('id');

        Swal.fire({
            title: 'Você tem certeza?',
            text: "O hospital será excluído",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, apagar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: 'hospitais/excluir',
                    type: 'DELETE',
                    data: {
                        id: idHospital,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result){
                        Swal.fire(
                            'Excluído!',
                            'O hospital foi excluído.',
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
    });/* END EXCLUIR HOSPITAL */

    $('#myTable tbody').on('click', '.btn-alterar-hospital', function(){ /* START ALTERAR HOSPITAL */

        var row = myTable.row($(this).closest('tr')).data();

        var idHospital = $(this).attr('id');

        $('#btnAlterarHospital').attr('data-id', idHospital);

        $('#nome-alt').val(row[0]);

    });

    $('#btnAlterarHospital').on('click', function(){/* START ALTERAR HOSPITAL */

        var idHospital = $(this).attr('data-id');
        let btn = $(this);
        let btn_text = btn.html();

        btn_disable(btn);

        $.ajax({
            url: 'hospitais/alterar',
            type: 'PUT',
            data: {
                id: idHospital,
                nome: $('#nome-alt').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(result){
                response = result;
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Os dados do hospital foram alterados',
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

    }); /* END ALTERAR HOSPITAL */

});


</script>
@endsection
