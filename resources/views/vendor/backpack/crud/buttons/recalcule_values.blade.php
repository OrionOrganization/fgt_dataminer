<button
  type="button"
  class="btn btn-sm btn-link"
  onclick="recalcule(this)"
  data-route="{{ route('entity-recalcule') }}"
  data-key="{{ $entry->key }}"
>
  <span class="ladda-label">
    <i class="la la-redo-alt"></i> Recalcular
  </span>
</button>

@unless(request()->ajax()) @push('after_scripts') @endunless
<script>
   if (typeof recalcule != 'function') {
    function recalcule(btn) {
        const route = $(btn).data('route');
        const key = $(btn).data('key');
        swal({
            dangerMode: true,
            icon: 'warning',
            title: "{{ trans('Recalcular valores?') }}",
            buttons: [
                "{!! trans('backpack::crud.cancel') !!}",
                "{{ trans('Sim') }}"
            ],
        }).then(function (value) {
            if (value) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        key: key
                    },
                    success: function (result) {
                        if(result.success) {
                            new Noty({
                                type: 'success',
                                text: 'Valores recalculados com sucesso!'
                            }).show();

                            crud.table.ajax.reload();
                        } else {
                            new Noty({
                                type: 'error',
                                text: 'Ocorreu um erro recalcular valores!'
                            }).show();
                        }
                    },
                    error: function (result) {
                        new Noty({
                            type: 'error',
                            text: 'Ocorreu um erro recalcular valores!'
                        }).show();
                    }
                });
            }
        });
    }
    }
</script>
@unless(request()->ajax()) @endpush @endunless
