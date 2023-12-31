<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Listeners;

use Modules\Documents\Models\Document;
use Modules\Documents\Models\DocumentTemplate;
use Modules\Users\Events\TransferringUserData;

class TransferDocumentsUserData
{
    /**
     * Handle the event.
     */
    public function handle(TransferringUserData $event): void
    {
        $this->documents($event->toUserId, $event->fromUserId);
        $this->documentTemplates($event->toUserId, $event->fromUserId);
    }

    /**
     * Transfer documents.
     */
    public function documents($toUserId, $fromUserId): void
    {
        Document::withTrashed()->where('created_by', $fromUserId)->update(['created_by' => $toUserId]);
        Document::withTrashed()->where('user_id', $fromUserId)->update(['user_id' => $toUserId]);
        Document::withTrashed()->where('sent_by', $fromUserId)->update(['sent_by' => $toUserId]);
        Document::withTrashed()->where('marked_accepted_by', $fromUserId)->update(['marked_accepted_by' => $toUserId]);
        Document::withTrashed()->where('approved_by', $fromUserId)->update(['approved_by' => $toUserId]);
    }

    /**
     * Transfer shared document templates.
     */
    public function documentTemplates($toUserId, $fromUserId): void
    {
        DocumentTemplate::where('user_id', $fromUserId)->where('is_shared', true)->update(['user_id' => $toUserId]);
    }
}
