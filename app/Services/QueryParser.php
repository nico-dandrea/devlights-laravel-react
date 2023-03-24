<?php

namespace App\Services;

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
        if ($this->queries->count() == 1) {
        }
        return $this->queries->map(function ($part) {

            $parts = $this->stringParts($part);
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
                throw new \Exception("The query string is malformed", 400);
            }

            //Checks if the string after the operator is a natural number
            if (!is_numeric($value) || $value <= 0) {
                throw new \Exception("The price is not a valid number", 400);
            }

            return collect([
                'attribute' => 'sale_price',
                'operator' => $operator,
                'value' => $value
            ]);
        });
    }

    /**
     * Formatter helper for the query string
     *
     * @param string $query
     * @return Illuminate\Support\Collection
     **/
    protected function stringParts(string $query)
    {
        //Retrieves the operator part of the string
        $operator = collect([':', '=', '>', '<'])->first(fn ($op) => Str::contains($query, $op));

        if ($operator === null) {
            throw new \Exception('The string does not contain an operator', 400);
        }

        //Retrieves the column name that the value will use to compare against the db
        $property = str($query)->before($operator)->trim()->snake()->__toString();

        if (!Str::contains($property, ['title', 'sale_price'])) {
            throw new \Exception('The string does not contain a valid property name', 400);
        }

        return collect([
            'operator' => $operator,
            $property => trim(Str::after($query, $operator))
        ]);
    }

    /**
     * Function that validates if the parts are valid for a title comparison
     *
     * @param mixed $parts
     * @return bool
     * @throws \Exception
     **/
    public function isValidTitle(mixed $parts)
    {
        return $parts->has('title') && $parts->contains([':', '=']) ?? throw new \Exception('The string is not a valid title comparison', 400);
    }
}
