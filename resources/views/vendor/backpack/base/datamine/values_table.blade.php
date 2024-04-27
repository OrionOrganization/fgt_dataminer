<table class="table table-bordered table-condensed table-striped m-b-0">
    <thead>
        <tr>
            <th>Tipo Valor</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_all) ?? 0 }}</td>
        </tr>
        <tr>
            <td>Ajuizado</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_indicador_ajuizado) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Não Ajuizado</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_n_indicador_ajuizado) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Em Benefício Fiscal</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_tax_benefit) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Em Cobrança</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_in_collection) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Em Negociação</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_in_negociation) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Em Garantia</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_guarantee) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Em Garantia</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_suspended) ?? 0  }}</td>
        </tr>
        <tr>
            <td>Outros</td>
            <td>{{ \App\Traits\Crud\HandlesCrudFields::money($entry->value->value_type_others) ?? 0  }}</td>
        </tr>
    </tbody>
</table>