<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client;

use Illuminate\Support\Collection;

trait MasksMessages
{
    /**
     * Mask given messages into a given class
     *
     * @param  array|\Illuminate\Support\Collection  $messages
     * @param  string  $maskIntoClass
     * @return \Illuminate\Support\Collection
     */
    protected function maskMessages($messages, $maskIntoClass)
    {
        if (! $messages) {
            $messages = [];
        }

        if (! $messages instanceof Collection) {
            $messages = collect($messages);
        }

        return $messages->map(function ($message) use ($maskIntoClass) {
            return $this->maskMessage($message, $maskIntoClass);
        });
    }

    /**
     * Mask a given message
     *
     * @param  mixed  $message
     * @param  string  $maskIntoClass
     * @return \Modules\MailClient\Client\Contracts\MessageInterface
     */
    protected function maskMessage($message, $maskIntoClass)
    {
        return new $maskIntoClass($message);
    }
}
