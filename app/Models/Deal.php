<?php

namespace App\Models;

use App\Services\QueryParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'deal_id';


    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Scope by a query string.
     */
    public function scopeSearch(Builder $query, string $queryString): void
    {


        // Parse the query string into a collection of query parts
        $parsedQuery = QueryParser::parse($queryString);

        // Check if the query has an operator it means it's a single query
        if ($parsedQuery->has('operator')) {
            $query->where($parsedQuery->get('property'), $parsedQuery->get('operator'), $parsedQuery->get('value'));
        } else {
            // If it doesn't have an operator, iterate over each query part
            foreach ($parsedQuery as $queryParts) {

                $query->where($queryParts->get('property'), $queryParts->get('operator'), $queryParts->get('value'));
            }
        }
    }

    public function releaseDate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::createFromTimestamp($value)->format('Y/m/d'),
        );
    }
}
