<button
  type="button"
  class="btn btn-primary"
  data-toggle="modal"
  data-target="#maskModal"
>
  <span class="ladda-label">
    <i class="las la-calculator"></i> Calcular Valores
  </span>
</button>

@unless(request()->ajax()) @push('after_scripts') @endunless
@include(backpack_view('base.datamine.recalcule_values_modal'))

<script>
    if (typeof recalculeTop != 'function') {
        function recalculeTop(btn) {
            const inputValue = $('#cpfCnpjInput').val();
            const route = "{{ route('entity-recalcule') }}";
            $('#cpfCnpjInput').val('');

            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    key: inputValue
                },
                success: function (result) {
                    if (result.success) {
                        new Noty({
                            type: 'success',
                            text: 'Valores recalculados com sucesso!'
                        }).show();

                        crud.table.ajax.reload();
                    } else {
                        new Noty({
                            type: 'error',
                            text: 'Ocorreu um erro ao recalcular valores!'
                        }).show();
                    }
                },
                error: function (result) {
                    console.log(result);
                    new Noty({
                        type: 'error',
                        text: 'Ocorreu um erro ao recalcular valores!'
                    }).show();
                }
            });
            
            $('#maskModal').modal('hide');
        }
    }
</script>
@unless(request()->ajax()) @endpush @endunless