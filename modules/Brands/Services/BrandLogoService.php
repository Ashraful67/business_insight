<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Brands\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Brands\Models\Brand;

class BrandLogoService
{
    /**
     * Store the given brand logo
     */
    public function store(UploadedFile $file, Brand $brand, string $type): Brand
    {
        $this->delete($brand, $type);

        $brand->{'logo_'.$type} = $file->store('brands', 'public');

        $brand->save();

        return $brand;
    }

    /**
     * Remove the brand logo from storage
     */
    public function delete(Brand $brand, string $type): static
    {
        $logo = $brand->{'logo_'.$type};

        if ($logo) {
            Storage::disk('public')->delete($logo);
        }

        return $this;
    }
}
