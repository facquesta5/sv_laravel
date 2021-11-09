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
                            <td class="text-center">
                                <i class="far fa-edit btn-alterar-ocorrencia" data-target="#modal-ocorrencia-alterar"
                                data-toggle="modal" id="{{ $ocorrencia->id }}"></i>
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
                    <select name="id_hospital" id="id_hospital"  class="form-select">
                        <option>--- Selecione um Hospital ---</option>
                        @foreach ($hospitais as $hospital)
                            <option id="{{$hospital->id }}">{{$hospital->nome }}</option>
                        @endforeach
                    </select>
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
                    <label for="" class="form-label">Equipamento</label>
                    <select name="id_equipamento" id="id_equipamento"  class="form-select">
                        <option>--- Selecione um Sistema ---</option>
                        @foreach ($equipamentos as $equipamento)
                            <option id="{{$equipamento->id }}">{{$equipamento->nome }}</option>
                        @endforeach
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
@endsection

@section('js')
<script>

$('document').ready(function(){

    var myTable = setDatatable($('#myTable'));

    $('#btnNovoOcorrencia').on('click', function(){

        let btn = $(this);
        let btn_text = btn.html();
        btn_disable(btn);

        $.ajax({
            url: 'ocorrencias/incluir',
            type: 'POST',
            data: {
                id_equipamento: '2',
                id_sistema: $('#id_sistema option:selected').attr('id'),
                id_hospital: $('#id_hospital option:selected').attr('id'),
                descricao: $('#descricao').val(),
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

    });

});

</script>
@endsection