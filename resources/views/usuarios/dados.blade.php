@extends('template.initial')

@section('content')

<form>
<h5 class="mt-2">Dados do usuário</h5>

<div class="col-12 mt-2">
    <small class="text-muted">Nome completo</small>
    <h6 class="my-0">Fernando Queiroz Acquesta</h6>   
</div>

<div class="col-12 mt-1">
    <small class="text-muted">Email</small>
    <h6 class="my-0">facquesta5@gmail.com</h6>
</div>

<div class="col-12 mt-1">
    <small class="text-muted">Usuário</small>
    <h6 class="my-0">facquesta</h6>
</div>

<button class="btn btn-primary btn-lg mt-3" type="submit">Editar usuário?</button>
</form>
@endsection