<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'metacriticLink' => $this->metacritic_link,
            'dealID' => $this->deal_id,
            'storeID' => $this->store_id,
            'gameID' => $this->game_id,
            'salePrice' => $this->sale_price,
            'normalPrice' => $this->normal_price,
            'isOnSale' => $this->is_on_sale,
            'savings' => $this->savings,
            'metacriticScore' => $this->metacritic_score,
            'steamRatingText' => $this->steam_rating_text,
            'steamRatingPercent' => $this->steam_rating_percent,
            'steamRatingCount' => $this->steam_rating_count,
            'steamAppid' => $this->steam_app_id,
            'releaseDate' => $this->release_date,
            'lastChange' => $this->last_change,
            'dealRating' => $this->deal_rating,
            'thumb' => $this->thumb,
        ];
    }
}
