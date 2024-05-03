@extends(backpack_view('blank'))

@push('after_styles')
    <style>
        .kanban {
            display: flex;
            min-height: 400px;
            gap: 15px;
            padding: 10px 0;
            overflow-y: scroll;
        }

        .column-container {
            display: flex;
            flex-direction: column;
            min-width: 250px;
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
            min-height: 250px;
            max-height: 380px;
            overflow-y: scroll;
            padding: 10px;
        }

        .item {
            color: #1E1E1E;
            cursor: grab;
        }

        .dragging {
            opacity: 0.5;
        }

        .card-header {
            background-color: #467fd0;
            color: #fff;
            padding-inline: 10px;
            padding-block: 10px;
        }

        .card-body {
            min-height: 70px;
            padding-inline: 10px;
            padding-block: 10px;
        }

        #collapseFilters {
            margin-top: 20px;
            padding-left: 0
        }
    </style>
@endpush

@section('content')
    {{-- OPORTINIDADES --}}
    <h1><i class="las la-thumbtack"></i> Oportunidades</h1>

    {{-- FILTROS BOTAO --}}
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
        <i class="las la-filter"></i>
    </button>

    {{-- CRIAR OPORTUNIDADE --}}
    <a href="{{ route('oportunity.create') }}">
        <button class="btn btn-outline-primary">Criar Oportunidade</button>
    </a>

    {{-- FILTROS DIV --}}
    <div class="collapse" id="collapseFilters">
        <div class="card card-body">
            <div class="form-group d-flex">
                <div>
                    <label for="user-oportunity-filter">Usuário</label>
                    <select class="form-control" id="user-oportunity-filter">
                        <option value="">-</option>

                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date-oportunity-filter" style="margin-left: 10px">Data</label>
                    <input type="date" class="form-control" id="date-oportunity-filter" style="margin-left: 10px">
                </div>
                <div>
                    <label for="order-oportunity-filter" style="margin-left: 20px">Ordenar</label>
                    <select class="form-control" id="order-direction-oportunity-filter" style="margin-left: 20px; margin-bottom: 5px">
                        <option value="DESC">Descrescente</option>
                        <option value="ASC">Crescente</option>
                    </select>
                    <select class="form-control" id="order-oportunity-filter" style="margin-left: 20px">
                        <option value="">-</option>
                        <option value="date">Data</option>
                        <option value="created_at">Criação</option>
                        <option value="updated_at">Atualização</option>
                    </select>
                </div>

                <div>
                    <button class="btn btn-primary" id="apply-oportunity-filters" style="margin-left: 30px; margin-top: 30px"><i class="las la-filter"></i> Aplicar</button>
                    <button class="btn btn-danger" id="clear-oportunity-filters" style="margin-top: 30px"><i class="las la-window-close"></i>Limpar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="kanban">
        @foreach ($oportunitiesStatus as $statusId => $status)
            <div class="column-container" data-type='oportunity'>
                <div class="column-header">
                    <span><h5>{{ $status }}</h5></span>
                </div>
                <div class="column-body" data-type='oportunity' data-id="{{ $statusId }}">
                    @php
                        $statusOportunity = isset($oportunities[$statusId]) ? $oportunities[$statusId] : [];
                    @endphp
                    @foreach ($statusOportunity as $oportunity)
                        @php
                            $formatedDate = (!$oportunity->date) ? '-' : \Carbon\Carbon::parse($oportunity->date)->format('d/m/y');
                            $responsibleName = ($oportunity->responsible) ? $oportunity->responsible->name : '-';
                        @endphp
                        <div
                            class="card item"
                            draggable="true"
                            data-type='oportunity'
                            data-id="{{ $oportunity->status }}"
                            data-status-old="{{ $statusId  }}"
                            data-route="{{ route('oportunity-update-status', ['model' => $oportunity]) }}"
                        >
                            <div class="card-header">
                                <i class="nav-icon las la-user"></i> {{ $responsibleName }} <br>
                                <i class="nav-icon las la-calendar-alt"></i> {{ $formatedDate }}
                            </div>
                            <div class="card-body">
                                <a href="{{ backpack_url('/oportunity/' . $oportunity->id . '/show') }}" target="_blank">
                                    <i class="nav-icon las la-thumbtack"></i> {{ Str::limit($oportunity->name, 32) ?? 'Sem nome' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- TAREFAS --}}
    <h1 class="mt-5"><i class="las la-tasks"></i> Tarefas</h1>

    {{-- FILTROS BOTAO --}}
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltersTasks" aria-expanded="false" aria-controls="collapseFiltersTasks">
        <i class="las la-filter"></i>
    </button>

    {{-- CRIAR TAREFA --}}
    <a href="{{ backpack_url('/task/create') }}">
        <button class="btn btn-outline-primary">Criar Tarefa</button>
    </a>

    {{-- FILTROS DIV --}}
    <div class="collapse" id="collapseFiltersTasks">
        <div class="card card-body">
            <div class="form-group d-flex">
                <div>
                    <label for="user-task-filter">Responsável</label>
                    <select class="form-control" id="user-task-filter">
                        <option value="">-</option>

                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date-task-filter" style="margin-left: 10px">Data Entrega</label>
                    <input type="date" class="form-control" id="date-task-filter" style="margin-left: 10px">
                </div>
                <div>
                    <label for="order-task-filter" style="margin-left: 20px">Ordenar</label>
                    <select class="form-control" id="order-direction-task-filter" style="margin-left: 20px; margin-bottom: 5px">
                        <option value="DESC">Descrescente</option>
                        <option value="ASC">Crescente</option>
                    </select>
                    <select class="form-control" id="order-task-filter" style="margin-left: 20px">
                        <option value="">-</option>
                        <option value="due_date">Data Entrega</option>
                        <option value="created_at">Criação</option>
                        <option value="updated_at">Atualização</option>
                    </select>
                </div>

                <div>
                    <button class="btn btn-primary" id="apply-task-filters" style="margin-left: 30px; margin-top: 30px"><i class="las la-filter"></i> Aplicar</button>
                    <button class="btn btn-danger" id="clear-task-filters" style="margin-top: 30px"><i class="las la-window-close"></i>Limpar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="kanban">
        @foreach ($taskStatus as $statusId => $status)
            <div class="column-container" data-type='task'>
                <div class="column-header">
                    <span><h5>{{ $status }}</h5></span>
                </div>
                <div class="column-body" data-type='task' data-id="{{ $statusId }}">
                    @php
                        $statusTasks = isset($tasks[$statusId]) ? $tasks[$statusId] : [];
                    @endphp
                    @foreach ($statusTasks as $task)
                        @php
                            if (!$oportunity = $task->oportunity) {
                                $oportunityName = '';
                                $nickname = 'sem empresa';
                            } else {
                                $oportunityName = $oportunity->name ?? '';
                                $nickname = optional($oportunity->company)->nickname ?? 'sem empresa';
                            }
                            $responsibleName = ($task->responsible) ? $task->responsible->name : '-';

                            $formatedDate = (!$task->due_date) ? '-' : \Carbon\Carbon::parse($task->due_date)->format('d/m/y');
                        @endphp
                        <div
                            class="card item"
                            draggable="true"
                            data-type='task'
                            data-id="{{ $task->status }}"
                            data-status-old="{{ $statusId  }}"
                            data-route="{{ route('task-update-status', ['model' => $task]) }}"
                        >
                            <div class="card-header">
                                <i class="nav-icon las la-user"></i> {{ $responsibleName }} <br>
                                <i class="nav-icon las la-calendar-alt"></i> {{ $formatedDate }}
                            </div>
                            <div class="card-body">
                                <a href="{{ backpack_url('/task/' . $task->id . '/show') }}" target="_blank">
                                    <i class="nav-icon las la-thumbtack"></i> {{ Str::limit($task->name, 42) ?? 'Sem nome' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const columns = document.querySelectorAll(".column-body");

        let columnType = null;

        document.addEventListener("dragstart", (e) => {
            e.target.classList.add("dragging");
            columnType = $(e.target).data('type');
        });

        document.addEventListener("dragend", (e) => {
            e.target.classList.remove("dragging");

            const status = $(e.target.parentNode).data('id');
            const route = $(e.target).data('route');
            const statusOld = $(e.target).data('statusOld');

            const parentType = $(e.target.parentNode).data('type');
            const eType = $(e.target).data('type');

            if (eType != columnType) {
                e.preventDefault();
                return;
            }

            if ((status != null) && (status != statusOld)) {
                $(e.target).data('statusOld', status);

                $.ajax({
                    url: route,
                    type: 'POST',
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

                const parentType = $(e.target.parentNode).data('type');
                const eType = $(e.target).data('type');

                if (parentType != columnType || columnType != eType) {
                    return;
                }

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

        function updateOrAddParam(url, paramName, paramValue) {
            var re = new RegExp("([?&])" + paramName + "=.*?(&|$)", "i");
            var separator = url.indexOf('?') !== -1 ? "&" : "?";
            if (paramValue) {
                if (url.match(re)) {
                    return url.replace(re, '$1' + paramName + "=" + paramValue + '$2');
                } else {
                    return url + separator + paramName + "=" + paramValue;
                }
            }
        }

        $('#apply-oportunity-filters').on('click', function() {
            let currentUrl = window.location.href;

            const userFilterData = $('#user-oportunity-filter').val();
            const dateFilterData = $('#date-oportunity-filter').val();
            const orderFilterData = $('#order-oportunity-filter').val();
            const orderDirectionFilterData = $('#order-direction-oportunity-filter').val();

            if (userFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'oportunity_user_id', userFilterData);
            }
            if (dateFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'oportunity_date', dateFilterData);
            }
            if (orderFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'oportunity_order', orderFilterData);
                currentUrl = updateOrAddParam(currentUrl, 'oportunity_order_direction', orderDirectionFilterData);
            }

            window.location.href = currentUrl;
        });

        $('#apply-task-filters').on('click', function() {
            let currentUrl = window.location.href;

            const userFilterData = $('#user-task-filter').val();
            const dateFilterData = $('#date-task-filter').val();
            const orderFilterData = $('#order-task-filter').val();
            const orderDirectionFilterData = $('#order-direction-task-filter').val();

            if (userFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'task_user_id', userFilterData);
            }
            if (dateFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'task_date', dateFilterData);
            }
            if (orderFilterData) {
                currentUrl = updateOrAddParam(currentUrl, 'task_order', orderFilterData);
                currentUrl = updateOrAddParam(currentUrl, 'task_order_direction', orderDirectionFilterData);
            }

            window.location.href = currentUrl;
        });

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);

            const oportunityUserFilterData = urlParams.get('oportunity_user_id');
            const oportunityDateFilterData = urlParams.get('oportunity_date');
            const oportunityOrderFilterData = urlParams.get('oportunity_order');
            const taskUserFilterData = urlParams.get('task_user_id');
            const taskDateFilterData = urlParams.get('task_date');
            const taskOrderFilterData = urlParams.get('task_order');
            const taskOrderDirectionFilterData = urlParams.get('task_order_direction');

            $('#user-task-filter').val(taskUserFilterData);
            $('#date-task-filter').val(taskDateFilterData);
            $('#order-task-filter').val(taskOrderFilterData);

            $('#user-oportunity-filter').val(oportunityUserFilterData);
            $('#date-oportunity-filter').val(oportunityDateFilterData);
            $('#order-oportunity-filter').val(oportunityOrderFilterData);
        });

        function clearFilters(parameters) {
            let currentUrl = window.location.href;
            const urlParams = new URLSearchParams(window.location.search);

            parameters.forEach(param => {
                urlParams.delete(param);
            });

            currentUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();

            window.location.href = currentUrl;
        }

        $('#clear-oportunity-filters').on('click', function() {
            clearFilters(['oportunity_user_id', 'oportunity_date', 'oportunity_order', 'oportunity_order_direction']);
        });

        $('#clear-task-filters').on('click', function() {
            clearFilters(['task_user_id', 'task_date', 'task_order', 'task_order_direction']);
        });
    </script>
@endpush
