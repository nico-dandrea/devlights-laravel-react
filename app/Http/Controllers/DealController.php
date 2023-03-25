<?php

namespace App\Http\Controllers;

use App\Http\Resources\DealCollection;
use App\Models\Deal;
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
        return Inertia::render('Index', [
            'deals' => Cache::remember('deals', 120, fn () => new DealCollection(Deal::limit(10)->get())),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            // 'deals' => Cache::remember('deals', 120, fn () => Deal::search($request->get('q'))->paginate(15))
        ]);
    }
}
