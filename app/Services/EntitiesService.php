<?php

namespace App\Services;

use App\Models\Entities;
use App\Models\Labels;

class EntitiesService
{
    private int $entityId = 0;
    private string $entityType = '';
    private array $labels = [];

    /**
     * Checking for the existence of labels in the database
     *
     * @return array|true[]
     */
    private function labelsExists()
    {
        $items = Labels::select('id')
            ->whereIn('id', $this->labels)
            ->get()
            ->toArray();

        if (count($items) < count($this->labels)) {
            return [
                'status' => false,
                'data' => implode(',', array_diff($this->labels, array_column($items, 'id')))
            ];
        }

        return [
            'status' => true
        ];
    }

    /**
     * Service method for rerecording entity labels
     *
     * @param $data
     * @return array
     */
    public function rerecordingLabels($data): array
    {
        $this->entityId = $data['entity_id'];
        $this->entityType = $data['entity_type'];
        $this->labels = array_unique($data['labels_list']);

        if (count($this->labels) > 0) {

            $checkResult = $this->labelsExists();

            if (!$checkResult['status']) {
                return [
                    'data' => [
                        'message' => "Labels with requested ids ({$checkResult['data']}) not found"
                    ],
                    'status' => 404
                ];
            }
        }

        try {
            $entity = Entities::find($this->entityId);

            $entity->labels = count($this->labels) < 1 ? null : implode(',', $this->labels);

            $entity->save();

            return [
                'data' => '',
                'status' => 204
            ];
        } catch (\Exception $e) {
            return [
                'data' => [
                    'message' => mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8')
                ],
                'status' => 500
            ];
        }
    }

    /**
     * Service method for adding labels list of entity labels
     *
     * @param $data
     * @return array
     */
    public function addLabels($data): array
    {
        $this->entityId = $data['entity_id'];
        $this->entityType = $data['entity_type'];
        $this->labels = array_unique($data['labels_list']);

        $checkResult = $this->labelsExists();

        if (!$checkResult['status']) {
            return [
                'data' => [
                    'message' => "Labels with requested ids ({$checkResult['data']}) not found"
                ],
                'status' => 404
            ];
        }

        try {
            $entity = Entities::find($this->entityId);

            if (!isset($entity->labels)) {
                $entity->labels = implode(',', $this->labels);
            } else {
                $labels = array_unique(array_merge(explode(',', $entity->labels), $this->labels));
                $entity->labels = implode(',', $labels);
            }

            $entity->save();

            return [
                'data' => '',
                'status' => 204
            ];
        } catch (\Exception $e) {
            return [
                'data' => [
                    'message' => mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8')
                ],
                'status' => 500
            ];
        }
    }

    /**
     * Service method for removing labels from an entity's label list
     *
     * @param $data
     * @return array
     */
    public function deleteLabels($data): array
    {
        $this->entityId = $data['entity_id'];
        $this->entityType = $data['entity_type'];
        $this->labels = array_unique($data['labels_list']);

        $checkResult = $this->labelsExists();

        if (!$checkResult['status']) {
            return [
                'data' => [
                    'message' => "Labels with requested ids ({$checkResult['data']}) not found"
                ],
                'status' => 404
            ];
        }

        try {
            $entity = Entities::find($this->entityId);

            if (isset($entity->labels)) {
                $labels = explode(',', $entity->labels);
                $entity->labels = implode(',', array_diff($labels, $this->labels));

                $entity->save();
            }

            return [
                'data' => '',
                'status' => 204
            ];
        } catch (\Exception $e) {
            return [
                'data' => [
                    'message' => mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8')
                ],
                'status' => 500
            ];
        }
    }

    /**
     * Service method to get entity labels
     *
     * @param $data
     * @return array
     */
    public function getLabels($data): array
    {
        $this->entityId = $data['entity_id'];
        $this->entityType = $data['entity_type'];

        $entity = Entities::find($this->entityId);

        $labels = Labels::select('id', 'title')
            ->whereIn('id', explode(',', $entity->labels))
            ->get()
            ->toArray();

        return [
            'data' => [
                'items' => $labels
            ],
            'status' => 200
        ];
    }
}
