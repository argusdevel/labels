<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLabelsRequest;
use App\Http\Requests\DeleteLabelsRequest;
use App\Http\Requests\GetLabelsRequest;
use App\Http\Requests\RerecordingLabelsRequest;
use App\Services\EntitiesService;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    private EntitiesService $entitiesService;

    public function __construct(EntitiesService $entitiesService)
    {
        parent::__construct();

        $this->entitiesService = $entitiesService;
    }

    /**
     * Rerecording of the entity labels list action
     *
     * @param RerecordingLabelsRequest $request
     * @return JsonResponse
     */
    public function rerecordingLabels(RerecordingLabelsRequest $request): JsonResponse
    {
        $result = $this->entitiesService->rerecordingLabels($request->validated());
        return response()->json($result['data'], $result['status']);
    }

    /**
     * Adding labels of the entity labels list action
     *
     * @param AddLabelsRequest $request
     * @return JsonResponse
     */
    public function addLabels(AddLabelsRequest $request): JsonResponse
    {
        $result = $this->entitiesService->addLabels($request->validated());
        return response()->json($result['data'], $result['status']);
    }

    /**
     * Deleting labels from an entity's labels list action
     *
     * @param DeleteLabelsRequest $request
     * @return JsonResponse
     */
    public function deleteLabels(DeleteLabelsRequest $request): JsonResponse
    {
        $result = $this->entitiesService->deleteLabels($request->validated());
        return response()->json($result['data'], $result['status']);
    }

    /**
     * Get entity's labels list action
     *
     * @param GetLabelsRequest $request
     * @return JsonResponse
     */
    public function getLabels(GetLabelsRequest $request): JsonResponse
    {
        $result = $this->entitiesService->getLabels($request->validated());
        return response()->json($result['data'], $result['status']);
    }
}
