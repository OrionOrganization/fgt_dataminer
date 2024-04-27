<table class="table table-bordered table-condensed table-striped m-b-0">
    <thead>
        <tr>
            <th>Tipo Situação</th>
            <th>Situação Inscrição</th>
            <th>Valor Consolidado</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="datamineRawsTableBody">
        @php
            $dataRaws = $entry->datamineRaws()
                ->orderByTipoSituacao()
                ->orderByDescValorConsolidado()
                ->paginate(5);
        @endphp
        @foreach ($dataRaws as $data)
        <tr>
            <td>{{ $data->tipo_situacao_inscricao }}</td>
            <td>{{ $data->situacao_inscricao }}</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($data->valor_consolidado) }}</td>
            <td><a href="{{backpack_url('/datamine/raw/'. $data->id .'/show')}}" target="_blank"><i class="las la-external-link-alt"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>

<button id="loadMore" class="btn btn-primary">Carregar Mais</button>

@push('after_scripts')
<script>
    $(document).ready(function() {
        var nextPageUrl = '{{ $dataRaws->nextPageUrl() }}';

        $('#loadMore').click(function() {
            if (nextPageUrl) {
                $.get(nextPageUrl, function(data) {
                    $('#datamineRawsTableBody').append($(data).find('#datamineRawsTableBody').html());

                    var currentPage = nextPageUrl.match(/page=(\d+)/)[1];
                    var nextPage = parseInt(currentPage) + 1;
                    nextPageUrl = nextPageUrl.replace(/page=(\d+)/, 'page=' + nextPage);
                });
            }
        });
    });
</script>
@endpush