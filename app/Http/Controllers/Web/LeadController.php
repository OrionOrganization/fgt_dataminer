<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\LeadRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * @var \App\Repositories\LeadRepository
     */
    protected $leadRepository;

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $lead = $this->leadRepository->store($input);

            return response()->json([
                'lead' => $lead,
                'success' => true
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }
}