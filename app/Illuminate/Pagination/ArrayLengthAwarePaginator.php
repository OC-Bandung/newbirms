<?php

namespace App\Illuminate\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArrayLengthAwarePaginator
 * @package App\Illuminate\Pagination
 * see https://laracasts.com/discuss/channels/laravel/lengthawarepaginator-gives-keys-along-with-data-on-page-2
 */
class ArrayLengthAwarePaginator extends LengthAwarePaginator
{
    public function toArray()
    {
        $data = [];
        if ($this->currentPage > 1) {
            $tempdata = $this->items->toArray();
            foreach ($tempdata as $key => $value) {
                $data[] = $value;
            }
        } else {
            $data = $this->items->toArray();
        }

        return [
            'current_page' => $this->currentPage(),
            'data' => $data,
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'next_page_url' => $this->nextPageUrl(),
            'path' => $this->path,
            'per_page' => $this->perPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}