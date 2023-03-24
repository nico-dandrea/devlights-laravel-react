<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    public function scopeSearch(Builder $query, $request): void
    {
        $terms = str($request->input('q'))->explode(',');

        $terms->each(function ($term) use ($query) {

            $parts = str($term)->explode(' ');

            if ($parts->count() !== 3) throw new Exception('The query string is malformed', 400);

            [$attribute, $operator, $value] = $parts->map(fn ($value) => trim($value))->toArray();

            $query->when($attribute === 'title', function ($query) use ($operator, $value) {
                $comparisonOperator = str($operator)->contains('=') ? '=' : 'like';
                $query->where('title', $comparisonOperator, '%' . $value . '%');
            });

            $query->when($attribute === 'salePrice' && str($operator)->contains(['<', '>']), function ($query) use ($operator, $value) {
                $query->where('salePrice', $operator, $value);
            });
        });
    }
}
