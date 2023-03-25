<?php

namespace App\Models;

use App\Services\QueryParser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function scopeSearch(Builder $query, $queryString): void
    {
        $parser = new QueryParser($queryString);

        //When the queryString is not a collection of
        $query->when(
            $parser->parts() instanceof string,
            fn () => $query->where('title', 'like', '%' . $parser->parts() . '%'),
            //When the queryString is a collection
            $parser->parts()->each(
                //If the property is title
                fn ($part) => $query->when($part->has('title'),
                    fn () => $query->where('title', $part->get('operator'), $part->get('title')),
                    //If the property is sale_price
                    fn () => $query->where('sale_price', $part->get('operator'), $part->get('sale_price'))
                )
            )
        );
    }
}
