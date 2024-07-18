@if ($entry->isTypePj())
  <button
    type="button"
    class="btn btn-sm btn-link"
    onclick="createOportunity(this)"
    data-route="{{route('entity-create-oportunity', ['model' => $entry])}}"
  >
    <span class="ladda-label">
      <i class="las la-rocket"></i> Oportunidade
    </span>
  </button>

  @unless(request()->ajax()) @push('after_scripts') @endunless
  <script>
    if (typeof createOportunity != 'function') {
      function createOportunity(btn) {
        const route = $(btn).data('route');

        swal({
            dangerMode: true,
            icon: 'warning',
            title: "{{ trans('Criar oportunidade?') }}",
            text: "Automaticamente criará também uma nova empresa",
            buttons: [
                "{!! trans('backpack::crud.cancel') !!}",
                "{{ trans('Sim') }}"
            ],
        }).then(function (value) {
          if(value) {
            $.ajax({
              url: route,
              type: 'POST',
              success: function (result) {
                  if(result.success) {
                      new Noty({
                          type: 'success',
                          text: 'Oportunidade criada com sucesso!'
                      }).show();
                  } else {
                      new Noty({
                          type: 'error',
                          text: 'Ocorreu um erro criar a oportunidade!'
                      }).show();
                  }
              },
              error: function (result) {
                  new Noty({
                      type: 'error',
                      text: 'Ocorreu um erro criar a oportunidade!'
                  }).show();
              }
            });
          }
        });
      }
      }
  </script>
  @unless(request()->ajax()) @endpush @endunless
@endif
