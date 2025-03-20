<?php
namespace App\Filament\Resources\WebOrderResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\WebOrder;

/**
 * @property WebOrder $resource
 */
class WebOrderTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
