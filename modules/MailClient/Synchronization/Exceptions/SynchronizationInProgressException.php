<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Synchronization\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SynchronizationInProgressException extends Exception
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(__('mailclient::inbox.sync_in_progress'), 409);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response(['message' => $this->message], $this->code);
    }

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return true;
    }
}
