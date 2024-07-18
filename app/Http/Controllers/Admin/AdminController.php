<?php

namespace App\Http\Controllers\Admin;

use App\Enum\OportunityStatus;
use App\Enum\TaskStatus;
use App\Models\User;
use App\Repositories\OportunityRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * @var \App\Repositories\OportunityRepository
     */
    protected $oportunityRepository;

    /**
     * @var \App\Repositories\TaskRepository
     */
    protected $taskRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        OportunityRepository $oportunityRepository,
        TaskRepository $taskRepository
    ) {
        $this->middleware(backpack_middleware());
        $this->oportunityRepository = $oportunityRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {   
        $filters = $this->getFilters($request->all());

        $oportunitiesStatus = OportunityStatus::labels();

        $oportunities = $this->oportunityRepository->getOportunitiesGroupedByStatus($filters);

        $taskStatus = TaskStatus::labels();

        $tasks = $this->taskRepository->getTasksGroupedByStatus($filters);

        $users = User::all();

        return view(backpack_view('dashboard'), compact('oportunitiesStatus', 'oportunities', 'taskStatus', 'tasks', 'users'));
    }

    /**
     * @param array $request
     * 
     * @return array
     */
    protected function getFilters(array $requestData): array
    {
        return [
            'oportunity_user' => $requestData['oportunity_user_id'] ?? null,
            'oportunity_date' => $requestData['oportunity_date'] ?? null,
            'oportunity_order' => $requestData['oportunity_order'] ?? null,
            'oportunity_order_direction' => $requestData['oportunity_order_direction'] ?? null,
            'task_user' => $requestData['task_user_id'] ?? null,
            'task_date' => $requestData['task_date'] ?? null,
            'task_order' => $requestData['task_order'] ?? null,
            'task_order_direction' => $requestData['task_order_direction'] ?? null
        ];
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
