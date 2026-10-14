<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('seller.dashboard', ['figma' => 'seller_center']);
    }

    public function catalog(): View
    {
        return view('seller.stub', ['figma' => 'seller_center / Catalog Manager', 'title' => 'Catalog Manager']);
    }

    public function orders(): View
    {
        return view('seller.stub', ['figma' => 'seller_center / Orders', 'title' => 'Orders']);
    }

    public function promos(): View
    {
        return view('seller.stub', ['figma' => 'seller_center / Store Promos', 'title' => 'Store Promos']);
    }

    public function shipments(): View
    {
        return view('seller.stub', ['figma' => '10_Shipment_Management 1', 'title' => 'Shipment Management']);
    }
}
