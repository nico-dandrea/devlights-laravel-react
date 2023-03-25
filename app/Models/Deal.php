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
        $parsedQuery = QueryParser::parse($queryString);
        //When the parsedQuery has a single query
        $query->when(
            $parsedQuery->has('operator'),
            fn () => $query->where('title', 'like', $parsedQuery->get('title')),
            //Else iterate over each parsedQuery
            fn ($queryParts) => $query->when(
                //If the property is title
                $queryParts->has('title'),
                fn () => $query->where('title', $queryParts->get('operator'), $queryParts->get('title')),
                //If the property is sale_price
                fn () => $query->where('sale_price', $queryParts->get('operator'), $queryParts->get('sale_price'))
            )
        );
    }

    public function releaseDate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::createFromTimestamp($value)->format('Y/m/d'),
        );
    }
}
