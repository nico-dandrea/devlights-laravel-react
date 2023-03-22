<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;

class Filter
{
    /**
     * Invokable class that filters a query string from the request object
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Collection
     **/
    public function __invoke(Request $request)
    {
        $query = $request->input('q') ?? throw new Exception('Malformed query string', 400);
        $filters = str($query)->explode(',')
            ->map(function ($filter) {
                //Collect the filter key, operator and value by splitting the string by a whitespace delimiter, trimming the values and transforming it into an array
                $parts =  str($filter)->split(' ')->map(fn ($item) => str($item)->trim())->toArray();
                return collect(
                    [
                        'key' => $parts[0],
                        'operator' => $parts[1],
                        'value' => $parts[2]
                    ]
                );
            });
        $filters->filter(function ($filter) {
            return collect($filter)->doesntContain();
        });
    }
}
