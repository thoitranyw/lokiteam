<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\InjectAssetEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $shopId = session('shopId');
        event(new InjectAssetEvent($shopId));
        return view('dashboard.index');
    }
}
