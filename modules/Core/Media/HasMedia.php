<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Media;

use Illuminate\Support\Str;
use Plank\Mediable\Mediable;

/** @mixin \Modules\Core\Models\Model */
trait HasMedia
{
    use Mediable;

    /**
     * Boot HasMedia trait
     */
    protected static function bootHasMedia(): void
    {
        static::deleting(function ($model) {
            if (! $model->usesSoftDeletes() || $model->isForceDeleting()) {
                $model->purgeMedia();
            }
        });
    }

    /**
     * Purge the model media
     *
     * The function deletes the files and the storage folder when empty
     */
    public function purgeMedia(): void
    {
        $this->media()->get()->each->delete();
    }

    /**
     * Get the model media directory
     */
    public function getMediaDirectory(): string
    {
        $folder = Str::kebab(class_basename(get_called_class()));

        return config('core.media.directory').DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$this->id;
    }

    /**
     * Get the model media tag
     */
    public function getMediaTags(): array
    {
        return ['profile'];
    }
}
