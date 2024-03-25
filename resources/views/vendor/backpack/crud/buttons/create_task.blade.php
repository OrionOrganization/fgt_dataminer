<button
  type="button"
  class="btn btn-sm btn-link"
  onclick="createTask(this)"
  data-route="{{ route('create-task-by-oportunity', ['model' => $entry]) }}"
>
  <span class="ladda-label">
    <i class="las la-tasks"></i> Criar Tarefa
  </span>
</button>

@unless(request()->ajax()) @push('after_scripts') @endunless
<script>
   if (typeof createTask != 'function') {
    function createTask(btn) {
        const route = $(btn).data('route');

        swal({
            dangerMode: true,
            icon: 'warning',
            title: "{{ trans('Criar tarefa?') }}",
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
                                text: 'Tarefa criada com sucesso!'
                            }).show();
                        } else {
                            new Noty({
                                type: 'error',
                                text: 'Ocorreu um erro criar a tarefa!'
                            }).show();
                        }
                    },
                    error: function (result) {
                        new Noty({
                            type: 'error',
                            text: 'Ocorreu um erro criar a tarefa!'
                        }).show();
                    }
                });
            }
        });
    }
    }
</script>
@unless(request()->ajax()) @endpush @endunless