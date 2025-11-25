<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Block;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request, $year = null)
    {
        $user = auth()->user();
        $year = $year ?? date('Y');
        
        $monthlyLabels = ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
        
        $monthlyRevenueData = $this->getMonthlyRevenue($user, $year);
        
        return view('dashboard', compact(
            'monthlyLabels',
            'monthlyRevenueData'
        ));
    }
    
    private function getMonthlyRevenue($user, $year = null)
    {
        $year = $year ?? date('Y');
        
        $monthlyData = array_fill(0, 12, 0);
        
        $query = Invoice::query()
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount_usd) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month');
        
        if (!$user->isAdmin()) {
            $query->whereHas('customer.block', function ($q) use ($user) {
                $q->where('site_id', $user->site_id);
            });
        }
        
        $results = $query->get();

        foreach ($results as $result) {
            $monthIndex = $result->month - 1;
            $monthlyData[$monthIndex] = (float) $result->total;
        }
        
        return $monthlyData;
    }
    
    public function getMonthlyRevenueByYear(Request $request, $year)
    {
        $user = auth()->user();
        $monthlyRevenueData = $this->getMonthlyRevenue($user, $year);
        
        return response()->json([
            'success' => true,
            'data' => $monthlyRevenueData,
            'year' => $year
        ]);
    }

    public function getMonthlyRevenueData(Request $request)
    {
        $user = auth()->user();
        $year = $request->get('year', date('Y'));
        $monthlyRevenueData = $this->getMonthlyRevenue($user, $year);
        
        return response()->json([
            'success' => true,
            'data' => $monthlyRevenueData,
            'year' => $year
        ]);
    }
}
