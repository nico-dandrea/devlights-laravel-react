<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
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
        $dealResults = Deal::search($request->get('q'))->paginate(15)->cache();

        $cacheKey =  'deal.search.' . md5(json_encode($dealResults->toArray()));

        $ttl = 120;

        $deals = Cache::remember($cacheKey, $ttl, fn () => $dealResults);

        return Inertia::render('Deal/Index', compact('deals'));
    }
}
