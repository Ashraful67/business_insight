<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\WebForms\Enums;

enum WebFormSection: string
{
    case FILE = 'file-section';
    case FIELD = 'field-section';
    case SUBMIT = 'submit-button-section';
    case MESSAGE = 'message-section';
    case INTRODUCTION = 'introduction-section';
}
