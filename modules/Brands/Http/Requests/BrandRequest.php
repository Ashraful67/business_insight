<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Brands\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Modules\Brands\Models\Brand;
use Modules\Core\Rules\UniqueRule;

class BrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                UniqueRule::make(Brand::class, 'brand'),
                'max:191',
            ],
            'display_name' => 'required|string|max:191',
            'is_default' => 'nullable|required|boolean',
            'config.primary_color' => 'required|string|max:7',

            'config.pdf.font' => [
                Rule::requiredIf($this->isMethod('PUT')),
                'string',
                Rule::in(Arr::pluck(config('contentbuilder.fonts'), 'font-family')),
            ],
            'config.pdf.orientation' => [Rule::requiredIf($this->isMethod('PUT')), 'string'],
            'config.pdf.size' => [Rule::requiredIf($this->isMethod('PUT')), 'string'],
            'config.signature.bound_text' => [Rule::requiredIf($this->isMethod('PUT')), 'string'],
        ];
    }
}
