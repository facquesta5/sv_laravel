@extends('template.initial')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading p-3">
        <div class="row">
            <div class="col-md-12">
            <h2 class="float-start">Hospitais</h2>
                <button class="btn btn-success font-weight-bold float-end" 
                data-toggle="modal" data-target="#modal-usuario-adicionar">
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
                            <th>Alterar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($hospitais as $hospital) 
                        <tr class="text-center">
                            <td>{{ $hospital->nome }}</td>
                            <td>
                                <i class="far fa-edit btn-alterar-hospital" data-target="#modal-hospital-alterar"
                                data-toggle="modal" id="{{ $hospital->id }}"></i>
                            </td>
                            <td>
                                <i class="fas fa-trash btn-excluir-usuario" id="{{ $hospital->id }}"></i>
                            </td>
                        </tr>
                         @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection