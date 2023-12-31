<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Rules\UniqueRule;
use Modules\Core\Rules\ValidTimezoneCheckRule;
use Modules\Users\Models\User;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => [
                'required',
                'email',
                'max:191',
                UniqueRule::make(User::class, $this->user()->id),
            ],
            'time_format' => ['required', 'string', Rule::in(config('core.time_formats'))],
            'date_format' => ['required', 'string', Rule::in(config('core.date_formats'))],
            'first_day_of_week' => ['required', 'in:1,6,0', 'numeric'],
            'locale' => ['required', 'string', Rule::in(Innoclapps::locales())],
            'timezone' => ['required', 'string', new ValidTimezoneCheckRule],
        ];
    }
}
