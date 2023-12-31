<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Services;

use Modules\Core\Contracts\Services\CreateService;
use Modules\Core\Contracts\Services\Service;
use Modules\Core\Contracts\Services\UpdateService;
use Modules\Core\Models\Model;
use Modules\Core\Models\UserOrderedModel;
use Modules\Deals\Models\Pipeline;
use Modules\Deals\Models\Stage;

class PipelineService implements Service, CreateService, UpdateService
{
    public function create(array $attributes): Pipeline
    {
        $model = Pipeline::create($attributes);

        if (! $model->isPrimary()) {
            $model->saveVisibilityGroup($attributes['visibility_group'] ?? []);
        }

        if (isset($attributes['stages'])) {
            foreach ($attributes['stages'] as $key => $stage) {
                $model->stages()->create(array_merge($stage, [
                    'display_order' => $stage['display_order'] ?? $key + 1,
                ]));
            }
        }

        return $model;
    }

    public function update(Model $model, array $attributes): Pipeline
    {
        $model->fill($attributes)->save();

        if (! $model->isPrimary() && ($attributes['visibility_group'] ?? null)) {
            $model->saveVisibilityGroup($attributes['visibility_group']);
        }

        if (isset($attributes['stages'])) {
            foreach ($attributes['stages'] as $key => $stage) {
                if (! isset($stage['display_order'])) {
                    $stage['display_order'] = $key + 1;
                }

                if (isset($stage['id'])) {
                    Stage::find($stage['id'])->fill($stage)->save();
                } else {
                    Stage::create([...$stage, ...['pipeline_id' => $model->id]]);
                }
            }
        }

        return $model;
    }

    /**
     * Save the display order for the given pipeline
     */
    public function saveDisplayOrder(int $id, int $displayOrder, int $userId): void
    {
        $pipeline = Pipeline::find($id);

        if (is_null($pipeline->userOrder)) {
            $pipeline->userOrder()->save(
                new UserOrderedModel([
                    'display_order' => $displayOrder,
                    'user_id' => $userId,
                ])
            );

            return;
        }

        $pipeline->userOrder->update([
            'display_order' => $displayOrder,
        ]);
    }
}
