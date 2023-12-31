<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

use Illuminate\Support\Facades\Route;
use Modules\ThemeStyle\Http\Controllers\ThemeStyle;

Route::get('theme-style', ThemeStyle::class);
