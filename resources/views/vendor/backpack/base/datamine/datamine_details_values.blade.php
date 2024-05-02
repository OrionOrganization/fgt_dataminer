<button
    class="btn btn-primary"
    data-toggle="modal"
    data-target="#valuesModal"
>Detalhar Valores</button>

@php
    $cnpjData = optional($entry->datamineCnpj)->json;
@endphp

@push('after_scripts')
    <div class="modal" id="valuesModal" tabindex="-1" role="dialog" aria-labelledby="valuesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="valuesModalLabel">Relação de Dívidas Abertas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <b>Nome Empresarial: </b> {{$cnpjData['razao_social'] ?? $entry->extra['nome_devedor'] ?? '-'}} <br>
                <b>CPF/CNPJ: </b> {{$entry->key}} <br>
                <b>Domicílio: </b> {{$cnpjData['municipio'] ?? ''}} - {{$cnpjData['uf'] ?? ''}} <br>
                <b>Valor Total Dívidas: </b> {{$entry->value->getFormattedValue('value_all')}} <br>
                <b>Total Ajuizado: </b> {{$entry->value->getFormattedValue('value_indicador_ajuizado')}} <br>
                <b>Total Não Ajuizado: </b> {{$entry->value->getFormattedValue('value_n_indicador_ajuizado')}}

                <div class="accordion" id="accordionExample" style="margin-top: 10px"> 
                    @php
                        $valueTypes = \App\Enum\Datamine\SubscriptionSituationType::labels();
                    @endphp

                    @foreach ($valueTypes as $key => $typeLabel)
                        <div class="card">
                            <div class="card-header" id="heading_{{$key}}">
                                <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_{{$key}}" aria-expanded="false" aria-controls="collapse_{{$key}}">
                                    Valor {{$typeLabel}}: {{$entry->value->getFormattedValue($key)}}
                                </button>
                                </h2>
                            </div>
                        
                            <div id="collapse_{{$key}}" class="collapse" aria-labelledby="heading_{{$key}}" data-parent="#accordionExample">
                                <div class="card-body">
                                    @include(backpack_view('base.datamine.dividas_raws_table'), ['valueType' => $key, 'valueTypeLabel' => $typeLabel])
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        </div>
    </div>
@endpush