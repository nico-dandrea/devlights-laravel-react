<?php

namespace App\Services;

use Illuminate\Support\Str;

class QueryParser
{

    /** @var Illuminate\Support\Collection $queries */
    protected $queries;

    /** @var array $validOperators the valid operators for the parser */
    protected $validOperators = [':', '=', '>', '<'];

    /** @var array $titleOperators the valid operators for a title parser */
    protected $titleOperators = [':', '='];

    /** @var array $priceOperators the valid operators for a price parser */
    protected $priceOperators = ['>', '<'];


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

        //If the query has no comma, return the string

        if ($this->queries->count() == 1) {
            $query = $this->queries->first();
            return $this->queries->contains($this->validOperators) ? collect($this->stringParts($query)) : '%' . $query . '%';
        }


        return $this->queries->map(function ($part) {

            $parts = $this->stringParts($part);

            if ($parts->has('title') && !Str::contains($parts->get('operator'), $this->priceOperators)) {
                throw new \Exception('The title has an invalid operator', 400);
            }

            if ($parts->has('sale_price') && is_numeric($parts->get('value'))) {
                throw new \Exception('The price is not a valid number', 400);
            }

            if ($parts->has('sale_price') && $parts->get('value') < 0) {
                throw new \Exception('The price must be a number greater than zero', 400);
            }

            return $parts;
        });
    }

    /**
     * Formatter helper for the query string
     *
     * @param string $query
     * @throws \Exception
     * @return Illuminate\Support\Collection
     **/
    protected function stringParts(string $query)
    {
        //Retrieves the operator part of the string
        $operator = collect($this->validOperators)->first(fn ($op) => Str::contains($query, $op));

        if ($operator === null) {
            throw new \Exception('The string does not contain an operator', 400);
        }

        //Retrieves the column name that the value will use to compare against the db
        $property = str($query)->before($operator)->trim()->snake()->__toString();

        if (!Str::contains($property, ['title', 'sale_price'])) {
            throw new \Exception('The string does not contain a valid property name', 400);
        }

        $value = trim(Str::after($query, $operator));

        return collect([
            'operator' => $operator,
            $property => $operator == ':' ? '%' . $value . '%' : $value
        ]);
    }
}
