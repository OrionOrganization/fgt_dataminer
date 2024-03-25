<button
  type="button"
  class="btn btn-sm btn-link"
  onclick="convertLead(this)"
  data-route="{{ route('lead-convert', ['model' => $entry]) }}"
>
  <span class="ladda-label">
    <i class="las la-exchange-alt"></i> Converter
  </span>
</button>

@unless(request()->ajax()) @push('after_scripts') @endunless
<script>
   
   if (typeof convertLead != 'function') {
    function convertLead(btn) {
        const route = $(btn).data('route');

        // Show the modal
        swal({
            dangerMode: true,
            icon: 'warning',
            title: "{{ trans('Converter Lead?') }}",
            buttons: [
                "{!! trans('backpack::crud.cancel') !!}",
                "{{ trans('Sim') }}"
            ],
        }).then(function (value) {
            if (value) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    success: function (result) {
                        if(result.success) {
                            new Noty({
                                type: 'success',
                                text: 'Lead convertido com sucesso!'
                            }).show();
                        } else {
                            new Noty({
                                type: 'error',
                                text: 'Ocorreu um erro ao converter o lead!'
                            }).show();
                        }
                    },
                    error: function (result) {
                        new Noty({
                            type: 'error',
                            text: 'Ocorreu um erro ao converter o lead!'
                        }).show();
                    }
                });
            }
        });
    }
    }
</script>
@unless(request()->ajax()) @endpush @endunless