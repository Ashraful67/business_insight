<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Console\Commands;

use Illuminate\Console\Command;
use Modules\Documents\Models\Document;
use Modules\Documents\Services\DocumentSendService;

class SendScheduledDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the documents which are scheduled for sending.';

    /**
     * Execute the console command.
     */
    public function handle(DocumentSendService $sendService): void
    {
        Document::dueForSending()->get()->each(function ($document) use ($sendService) {
            try {
                $sendService->send($document);
            } finally {
                $document->fill(['send_at' => null])->save();
            }
        });
    }
}
