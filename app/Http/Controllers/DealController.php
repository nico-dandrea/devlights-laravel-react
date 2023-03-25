<?php

namespace App\Http\Controllers;

use App\Http\Resources\DealCollection;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Inertia\Response;
use Inertia\Inertia;

class DealController extends Controller
{
    /**

     * Display a listing of the resource.

     */

    public function index(Request $request): Response
    {
        try {
            $query = $request->input('q');
            $cacheKey = md5('deals.' . $query);
            if (str($query)->isNotEmpty()) {
                $deals = Deal::search($query)->limit(12);
            } else {
                $deals = Deal::limit(12);
            }
        } catch (\Throwable $th) {
            $deals = collect();
        }
        return Inertia::render('Index', [
            // 'deals' => $deals instanceof Builder ? new DealCollection($deals->get()) : $deals,
            'deals' => $deals instanceof Builder ? Cache::remember($cacheKey, 60, fn () => new DealCollection($deals->get())) : $deals,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
    // 'deals' => $deals instanceof Builder ? Cache::remember('deals', 120, fn () => new DealCollection($deals->get())) : $deals,
}
