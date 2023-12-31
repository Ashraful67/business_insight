<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Export\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidExportTypeException extends Exception
{
    /**
     * Create new InvalidExportTypeException instnace.
     *
     * @param  string  $type
     * @param  int  $code
     */
    public function __construct($type, $code = 0, Exception $previous = null)
    {
        parent::__construct("The export type \"$type\" is not supported.", $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], $this->getCode() ?: 500);
    }
}
