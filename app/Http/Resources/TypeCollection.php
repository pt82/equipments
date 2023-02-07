<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeCollection extends ResourceCollection
{
    /**
     * An array to store pagination data that comes from paginate() method.
     * @var array
     */
    protected $data;

    /**
     * PaginatedCollection constructor.
     *
     * @param mixed $resource paginated resource using paginate method on models or relations.
     */
    public function __construct($resource)
    {
        $this->data =  $resource;

        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  $this->data;
    }
}
