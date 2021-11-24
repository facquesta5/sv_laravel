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
                            <th class="text-center">Status</th>
                            <th>Equipamento</th>
                            <th>Sistema</th>
                            <th>Hospital</th>
                            <th>Ocorrencia</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($ocorrencias as $ocorrencia) 
                        <tr class="text-center">
                            <td class="text-center">
                                @if( $ocorrencia->id_status == 3 )
                                    <img width="16px" src="../images/vermelho.png" ></img>
                                @endif
                                @if( $ocorrencia->id_status == 2 )
                                    <img width="16px" src="../images/amarelo.png" ></img>
                                @endif
                                @if( $ocorrencia->id_status == 1 )
                                    <img width="16px" src="../images/verde.png" ></img>
                                @endif
                            </td>
                            <td>{{ $ocorrencia->equipamento }}</td>
                            <td>{{ $ocorrencia->sistema }}</td>
                            <td>{{ $ocorrencia->hospital }}</td>    
                            <td>{{ $ocorrencia->descricao }}</td>
                        </tr>
                         @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>

    $('document').ready(function(){

        var myTable = setDatatable($('#myTable'));

    });
    </script>
@endsection