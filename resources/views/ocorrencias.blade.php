@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h2 class="float-start">Ocorrencias</h2>
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