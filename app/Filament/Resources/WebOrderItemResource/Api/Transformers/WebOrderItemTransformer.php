<?php
namespace App\Filament\Resources\WebOrderItemResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\WebOrderItem;

/**
 * @property WebOrderItem $resource
 */
class WebOrderItemTransformer extends JsonResource
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
