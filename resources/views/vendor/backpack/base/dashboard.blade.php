@extends(backpack_view('blank'))

@push('after_styles')
    <style>
        .kanban {
            display: flex;
            min-height: 400px;
            gap: 10px;
            padding: 10px 0;
            overflow: scroll;
        }

        .column-container {
            display: flex;
            flex-direction: column;
            min-width: 230px;
            border-radius: 5px;
            background-color: hsla(0,0%,100%,.5);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06);
        }

        .column-header {
            width: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .column-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }

        .item {
            background-color: #4680d05e;
            color: #1E1E1E;
            padding: 10px;
            border-radius: 5px;
            cursor: grab;
        }

        .dragging {
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')
    {{-- OPORTINIDADES --}}
    <h1><i class="las la-thumbtack"></i> Oportunidades</h1>

    <div class="kanban">
        @php
            $oportunitiesStatus = \App\Enum\OportunityStatus::labels();
            $oportunities = \App\Models\Oportunity::with('company')->get();
        @endphp
        @foreach ($oportunitiesStatus as $statusId => $status)
            <div class="column-container">
                <div class="column-header">
                    <span><h5>{{ $status }}</h5></span>
                    <a href="{{ backpack_url('/oportunity/create') }}">
                        <button class="btn btn-outline-primary">Criar Oportunidade</button>
                    </a>
                </div>
                <div class="column-body" data-id="{{ $statusId }}">
                    @php
                        $statusOportunity = $oportunities->where('status', $statusId);
                    @endphp
                    @foreach ($statusOportunity as $oportunity)
                        <a
                            href="{{ backpack_url('/oportunity/' . $oportunity->id . '/show') }}"
                            target="_blank"
                            data-id="{{ $oportunity->status }}"
                            data-route="{{ route('oportunity-update-status', ['model' => $oportunity]) }}">
                            <div class="item" draggable="true">
                                <i class="nav-icon las la-thumbtack"></i> {{ $oportunity->name }}<br>
                                <i class="nav-icon las la-city"></i> {{ $oportunity->company->nickname }} <br>
                                <i class="nav-icon las la-calendar-alt"></i> {{ \Carbon\Carbon::parse($oportunity->date)->format('d/m/y') }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- TAREFAS --}}
    <h1 class="mt-5"><i class="las la-tasks"></i> Tarefas</h1>

    <div class="kanban mb-5">
        @php
            $taskStatus = \App\Enum\TaskStatus::labels();
            $tasks = \App\Models\Task::with('responsible')->get();
        @endphp
        @foreach ($taskStatus as $statusId => $status)
            <div class="column-container">
                <div class="column-header">
                    <span><h5>{{ $status }}</h5></span>
                    <a href="{{ backpack_url('/task/create') }}">
                        <button class="btn btn-outline-primary">Criar Tarefa</button>
                    </a>
                </div>
                <div class="column-body" data-id="{{ $statusId }}">
                    @php
                        $statusTasks = $tasks->where('status', $statusId);
                    @endphp
                    @foreach ($statusTasks as $task)
                        <a
                            href="{{ backpack_url('/task/' . $task->id . '/show') }}"
                            target="_blank"
                            data-id="{{ $task->status }}"
                            data-route="{{ route('task-update-status', ['model' => $task]) }}">
                            <div class="item" draggable="true">
                                <i class="nav-icon las la-thumbtack"></i> {{ $task->name }}<br>
                                <i class="nav-icon las la-user"></i> {{ $task->responsible->name }} <br>
                                <i class="nav-icon las la-calendar-alt"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/y') }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('after_scripts')
    <script>
        const columns = document.querySelectorAll(".column-body");

        document.addEventListener("dragstart", (e) => {
            e.target.classList.add("dragging");
        });

        document.addEventListener("dragend", (e) => {
            e.target.classList.remove("dragging");

            const status = $(e.target.parentNode).data('id');
            const route = $(e.target).data('route');

            if (status != null) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    data: { status },
                    success: function(response) {
                        new Noty({
                            type: 'success',
                            text: 'Item atualizado com sucesso.'
                        }).show();
                    },
                    error: function(xhr, status, error) {
                        new Noty({
                            type: 'error',
                            text: 'Ocorreu um erro ao atualizar o item.'
                        }).show();
                    }
                });
            }
        });

        columns.forEach((item) => {
            item.addEventListener("dragover", (e) => {
                const dragging = document.querySelector(".dragging");
                const applyAfter = getNewPosition(item, e.clientY);

                if (applyAfter) {
                    applyAfter.insertAdjacentElement("afterend", dragging);
                } else {
                    item.prepend(dragging);
                }
            });
        });

        function getNewPosition(column, posY) {
            const cards = column.querySelectorAll(".item:not(.dragging)");
            let result;

            for (let refer_card of cards) {
                const box = refer_card.getBoundingClientRect();
                const boxCenterY = box.y + box.height / 2;

                if (posY >= boxCenterY) result = refer_card;
            }

            return result;
        }
    </script>
@endpush