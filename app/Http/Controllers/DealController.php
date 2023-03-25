<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class DealController extends Controller
{
    /**

     * Display a listing of the resource.

     */

    public function index(Request $request): Response
    {
        return Inertia::render('Deal/Index', ['deals' => Deal::search($request->get('q'))->paginate(15)]);
    }
}
