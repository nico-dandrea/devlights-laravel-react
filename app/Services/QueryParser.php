<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;

class QueryParser
{

    /** @var Illuminate\Support\Collection $parts */
    protected $parts;

    /**
     * Invokable class that filters a query string from the request object
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Collection
     **/
    public function __construct(string $query)
    {
        $this->parts = str($query)->explode(' ');
    }

    /**
     * If the query doesn't have 3 keys, it means it is missing either an attribute, operator or value
     * @return bool
     * @throws \Exception
     */
    public function isValid()
    {
        return $this->parts->count() !== 3 ?? throw new Exception('The query string is malformed', 400);
    }
}
