<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function home(): View
    {
        return view('buyer.home', ['figma' => '01_Buyer_Home 1']);
    }

    public function addresses(): View
    {
        return view('buyer.stub', ['figma' => '02_Auth_Address 1', 'title' => 'Addresses']);
    }

    public function search(): View
    {
        return view('buyer.stub', ['figma' => '03_Search_Filters 1', 'title' => 'Search & Filters']);
    }

    public function cart(): View
    {
        return view('buyer.stub', ['figma' => '04_MultiSeller_Cart 1', 'title' => 'Multi-seller Cart']);
    }

    public function checkout(): View
    {
        return view('buyer.stub', ['figma' => '05_Checkout_Payment 1', 'title' => 'Checkout Payment']);
    }

    public function track(Order $order): View
    {
        abort_unless($order->buyer_id === auth()->id() || auth()->user()?->hasRole('admin'), 403);

        return view('buyer.track', ['figma' => '06_Order_Tracking_Chat 1', 'order' => $order]);
    }
}
