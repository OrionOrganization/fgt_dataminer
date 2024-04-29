<table class="table table-bordered table-condensed table-striped m-b-0">
    <thead>
        <tr>
            <th>Situação Inscrição</th>
            <th>Valor Consolidado</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="datamineRawsTableBody_{{$valueType}}">
        @php
            $dataRaws = $entry->datamineRaws()
                ->orderByDescValorConsolidado()
                ->where('tipo_situacao_inscricao', $valueTypeLabel)
                ->paginate(5);
        @endphp
        @forelse ($dataRaws as $data)
            <tr>
                <td>{{ $data->situacao_inscricao }}</td>
                <td>{{ \App\Traits\Crud\HandlesCrudFields::money($data->valor_consolidado) }}</td>
                <td><a href="{{backpack_url('/datamine/raw/'. $data->id .'/show')}}" target="_blank"><i class="las la-external-link-alt"></i></a></td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Nenhuma dívida encontrada</td>
            </tr>
        @endforelse
    </tbody>
</table>

<button class="btn btn-primary loadMore">Carregar Mais</button>

@push('after_scripts')
<script>
    $(document).ready(function() {
        var nextPageUrl = '{{ $dataRaws->nextPageUrl() }}';
        var tbodyId = '#datamineRawsTableBody_' + '{{$valueType}}';

        $('.loadMore').click(function() {
            if (nextPageUrl) {
                $.get(nextPageUrl, function(data) {
                    $(tbodyId).append($(data).find(tbodyId).html());

                    var currentPage = nextPageUrl.match(/page=(\d+)/)[1];
                    var nextPage = parseInt(currentPage) + 1;
                    nextPageUrl = nextPageUrl.replace(/page=(\d+)/, 'page=' + nextPage);
                });
            }
        });
    });
</script>
@endpush