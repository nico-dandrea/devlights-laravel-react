<?php

namespace Database\Seeders;

use App\Models\Deal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deals = json_decode(Storage::get('deals.json'));
        foreach ($deals as $deal) {
            $sqlDeal = collect($deal);
            Deal::create(
                [
                    'internal_name' => $sqlDeal->get('internalName'),
                    'title' => $sqlDeal->get('title'),
                    'metacritic_link' => $sqlDeal->get('metacriticLink'),
                    'deal_id' => $sqlDeal->get('dealID'),
                    'store_id' => $sqlDeal->get('storeID'),
                    'game_id' => $sqlDeal->get('gameID'),
                    'sale_price' => $sqlDeal->get('salePrice'),
                    'normal_price' => $sqlDeal->get('normalPrice'),
                    'is_on_sale' => $sqlDeal->get('isOnSale'),
                    'savings' => $sqlDeal->get('savings'),
                    'metacritic_score' => $sqlDeal->get('metacriticScore'),
                    'steam_rating_text' => $sqlDeal->get('steamRatingText'),
                    'steam_rating_percent' => $sqlDeal->get('steamRatingPercent'),
                    'steam_rating_count' => $sqlDeal->get('steamRatingCount'),
                    'steam_app_id' => $sqlDeal->get('steamAppID'),
                    'release_date' => $sqlDeal->get('releaseDate'),
                    'last_change' => $sqlDeal->get('lastChange'),
                    'deal_rating' => $sqlDeal->get('dealRating'),
                    'thumb' => $sqlDeal->get('thumb')
                ]
            );
        }
    }
}
