@extends(backpack_view('blank'))

@section('content')

<div class="row justify-content-center">
    <p>Enviar aquivo - DIVIDA aberta</p>

    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('datamine-file-store') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">1) Obter arquivo</label>
            <div class="col-sm-10">
                <a class='nav-link' href='https://www.gov.br/pgfn/pt-br/assuntos/divida-ativa-da-uniao/transparencia-fiscal-1/dados-abertos'>
                    <i class="nav-icon las la-archive"></i> obter arquivo -> d</a>
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">2) Escolha o Tipo</label>
            <div class="col-sm-10">
                <select
                    id='file_type'
                    name='file_type'
                    class="custom-select"
                    required>
                    <option value="">selecione um tipo</option>
                    <option value="1_divida_fgts">Dívida FGTS</option>
                    <option value="2_divida_ativa_nao_prev">Dívida Ativa Geral  - Não previdenciario </option>
                    <option value="3_divida_ativa_prev">Dívida Previdenciária</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-2 col-form-label">3) Informe o periodo</label>
            <div class="col-10">
                <div class="form-row">
                    <select class="custom-select col-6" id='date_quarter' name='date_quarter' required>
                        <option value="">selecione um trimestre</option>
                        <option value="1_tri">1º trimestre</option>
                        <option value="2_tri">2º trimestre:</option>
                        <option value="3_tri">3º trimestre:</option>
                        <option value="4_tri">4º trimestre:</option>
                    </select>
                    @php
                        $year = now()->year;
                    @endphp
                    <input
                        id='date_year'
                        name='date_year'
                        type="number"
                        min=1000
                        max={{$year}}
                        class="form-control col-6"
                        placeholder="Ano"
                        value="{{$year}}"
                        required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-2 col-form-label">4) Selecione o arquivo</label>
            <div class="col-10">
                <div class="custom-file">
                    <input
                        id='file'
                        name='file'
                        type="file"
                        class="form-control-file"
                        accept=".csv, text/csv"
                        required>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">ENVIAR</button>
    </form>
</div>

@endsection
