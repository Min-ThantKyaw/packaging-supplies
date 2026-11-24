<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Base class for every API resource.
 *
 * Conventions:
 * - single resources and collections are wrapped in `data`;
 * - money leaves the API as integer minor units (1 unit = 1 MMK);
 * - timestamps serialize as ISO 8601 UTC;
 * - resources never expose raw Eloquent models.
 */
abstract class Resource extends JsonResource
{
    public static $wrap = 'data';
}
