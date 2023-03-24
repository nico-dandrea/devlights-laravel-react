<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Str;

class QueryParser
{

    /** @var Illuminate\Support\Collection $queries */
    protected $queries;

    /**
     *
     * @param string $query
     **/
    public function __construct(string $query)
    {

        $this->queries = str($query)->explode(',');
    }

    /**
     * Tries to get the parts of the query has 3 keys, attribute, operator or value
     *
     * @return Illuminate\Support\Collection
     * @throws \Exception
     **/
    public function parts()
    {
        $parts = $this->queries->map(function ($part) {
            $operator = collect([':', '=', '>', '<'])->first(fn ($op) => Str::contains($part, $op));
            if (($attribute = Str::before($part, $operator)) == 'title' && Str::contains($operator, [':', '='])) {
                return collect(
                    [
                        'attribute' => $attribute,
                        'operator' => $operator,
                        'value' => Str::after($part, $operator)
                    ]
                );
            }

            if (!Str::contains($operator, ['>', '<']) && $attribute !== 'salePrice') {
                throw new Exception("The query string is malformed", 400);
            }

            if (!is_numeric($value = Str::after($part, $operator)) || $value <= 0) {
                throw new Exception("The price is not a valid number", 400);
            }

            return collect([
                'attribute' => 'sale_price',
                'operator' => $operator,
                'value' => $value
            ]);
        });

        if ($parts->every(fn ($part) => $part->count() == 3)) {
            return $parts;
        } else {
            throw new Exception('One or more of the properties ', 400);
        }
    }
}
