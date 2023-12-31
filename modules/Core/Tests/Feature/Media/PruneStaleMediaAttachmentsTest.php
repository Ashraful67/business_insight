<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Tests\Feature\Media;

use Illuminate\Support\Carbon;
use Modules\Core\Media\PruneStaleMediaAttachments;
use Modules\Core\Models\Media;
use Tests\TestCase;

class PruneStaleMediaAttachmentsTest extends TestCase
{
    public function test_it_prunes_stale_media_attachments()
    {
        Carbon::setTestNow(now()->subDay(1)->startOfDay());
        $media = $this->createMedia();

        $pendingMedia = $media->markAsPending('draft-id');

        Carbon::setTestNow(null);

        (new PruneStaleMediaAttachments)();

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
        $this->assertDatabaseMissing('pending_media_attachments', ['id' => $pendingMedia->id]);
    }

    protected function createMedia()
    {
        $media = new Media();

        $media->forceFill([
            'disk' => 'local',
            'directory' => 'media',
            'filename' => 'filename',
            'extension' => 'jpg',
            'mime_type' => 'image/jpg',
            'size' => 200,
            'aggregate_type' => 'image',
        ]);

        $media->save();

        return $media;
    }
}
