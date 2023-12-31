<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Tests\Concerns;

trait TestsMentions
{
    protected function mentionText($id, $name, $notified = 'false')
    {
        return '<span class="mention" data-mention-id="'.$id.'" data-notified="'.$notified.'">@'.$name.'</span>';
    }
}
