<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Workflow;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWorkflowAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Action $action)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Workflows::workflowRunning();

        try {
            $this->action->trigger()->runExecutionCallbacks($this->action);
            $this->action->run();
            $this->action->workflow->increment('total_executions');
        } finally {
            Workflows::workflowRunning(false);
        }
    }
}
