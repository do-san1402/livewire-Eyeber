<?php
 
namespace App\Http\Resource;
 
use Illuminate\Http\Resources\Json\ResourceCollection;
 
class BannerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'banners' => $this->collection,
        ];
    }
}