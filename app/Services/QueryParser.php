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
        //TODO implement check for count == 1 and another for count >= 1

        return $this->queries->map(function ($part) {

            //Retrieves the operator part of the string
            $operator = collect([':', '=', '>', '<'])->first(fn ($op) => Str::contains($part, $op));

            //Retrieves the value part of the string
            $value = trim(Str::after($part, $operator));

            //Checks if the string contains a valid title operator
            if (($attribute = trim(Str::before($part, $operator))) == 'title' && Str::contains($operator, [':', '='])) {
                return collect(
                    [
                        'attribute' => $attribute,
                        'operator' => $operator,
                        'value' => $value
                    ]
                );
            }

            //Checks if the string contains a valid sale price operator
            if (!Str::contains($operator, ['>', '<']) && $attribute !== 'salePrice') {
                throw new Exception("The query string is malformed", 400);
            }

            //Checks if the string after the operator is a natural number
            if (!is_numeric($value) || $value <= 0) {
                throw new Exception("The price is not a valid number", 400);
            }

            return collect([
                'attribute' => 'sale_price',
                'operator' => $operator,
                'value' => $value
            ]);
        });
    }
}
