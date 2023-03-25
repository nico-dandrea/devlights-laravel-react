<?php

namespace App\Services;

use App\Exceptions\EmptyValueException;
use App\Exceptions\InvalidPriceException;
use App\Exceptions\InvalidOperatorException;
use App\Exceptions\NegativeNumberException;
use Illuminate\Support\Str;

class QueryParser
{

    /** @var Illuminate\Support\Collection $queryStrings */
    protected static $queryStrings;

    /** @var array $validOperators the valid operators for the parser */
    private static $validOperators = [':', '=', '>', '<'];

    /** @var array $titleOperators the valid operators for a title parser */
    private static $titleOperators = [':', '='];

    /**
     * Tries to get the parts of the query has 3 keys, attribute, operator or value
     *
     * @param string $query
     * @return mixed
     * @throws \Exception
     **/
    public static function parse(string $query): mixed
    {

        self::$queryStrings = str($query)->explode(',');

        //If the query has no comma, return the string

        if (self::$queryStrings->count() == 1) {

            $query = self::$queryStrings->first();

            if (Str::contains($query, self::$validOperators)) {

                $parts = self::parseQueryString($query);

                self::validateParts($parts);

                return collect($parts);
            } else {

                return collect(self::parseQueryString('title:' . trim($query)));
            }
        }


        return self::$queryStrings->map(function ($string) {

            $parts = self::parseQueryString($string);

            self::validateParts($parts);

            return $parts;
        });
    }


    /**
     *
     * Function that checks if the query parts is correct
     *
     * @param mixed $parts
     * @return bool
     * @throws \Exception
     **/
    private static function validateParts(mixed $parts)
    {

        if ($parts->has('title') && !Str::contains($parts->get('operator'), self::$titleOperators)) {
            throw new InvalidOperatorException();
        }

        if ($parts->has('sale_price') && !is_numeric($parts->get('sale_price'))) {
            throw new InvalidPriceException();
        }

        if ($parts->has('sale_price') && $parts->get('sale_price') < 0) {
            throw new NegativeNumberException();
        }

        return true;
    }

    /**
     * Return a collection if the query string contains a valid operator
     *
     * @param string $query
     * @throws \Exception
     * @return Illuminate\Support\Collection
     **/
    private static function parseQueryString(string $query)
    {
        //Retrieves the operator part of the string
        $queryOperator = collect(self::$validOperators)->first(fn ($op) => Str::contains($query, $op));

        if ($queryOperator === null) {
            throw new InvalidOperatorException();
        }

        //Retrieves the column name that the value will use to compare against the db
        $queryProperty = str($query)->before($queryOperator)->trim()->snake()->__toString();

        $value = trim(Str::after($query, $queryOperator));

        if (empty($value)) {
            throw new EmptyValueException();
        }

        return collect([
            $queryProperty => $queryOperator == ':' ? '%' . $value . '%' : $value,
            'operator' => $queryOperator,
        ]);
    }
}
