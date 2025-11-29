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
        $monthlyExpenseData = $this->getMonthlyExpense($user, $year);
        
        return view('dashboard', compact(
            'monthlyLabels',
            'monthlyRevenueData',
            'monthlyExpenseData'
        ));
    }
    
    private function getMonthlyRevenue($user, $year = null, $month = null)
    {
        $year = $year ?? date('Y');

        $monthlyData = array_fill(0, 12, 0);

        $query = Invoice::query()
            ->selectRaw('MONTH(invoice_date) as month, SUM(total_amount_usd) as total')
            ->whereYear('invoice_date', $year);

        if ($month) {
            $query->whereMonth('invoice_date', $month);
        }

        if (!$user->isAdmin()) {
            $query->whereHas('customer.block', function ($q) use ($user) {
                $q->where('site_id', $user->site_id);
            });
        }

        $query->groupBy('month')->orderBy('month');

        $results = $query->get();

        foreach ($results as $result) {
            $monthIndex = $result->month - 1;
            $monthlyData[$monthIndex] = (float)$result->total;
        }

        return $monthlyData;
    }

    private function getMonthlyExpense($user, $year = null, $month = null)
    {
        $year = $year ?? date('Y');
        
        $electricData = array_fill(0, 12, 0);
        $waterData = array_fill(0, 12, 0);
        $garbageData = array_fill(0, 12, 0);

        $query = Invoice::query()
            ->selectRaw('MONTH(invoice_date) as month, 
                SUM(total_amount_electric) as electric,
                SUM(total_amount_water) as water,
                SUM(garbage_price) as garbage')
            ->whereYear('invoice_date', $year);

        if ($month) {
            $query->whereMonth('invoice_date', $month);
        }

        if (!$user->isAdmin()) {
            $query->whereHas('customer.block', function ($q) use ($user) {
                $q->where('site_id', $user->site_id);
            });
        }

        $query->groupBy('month')->orderBy('month');
        $results = $query->get();

        foreach ($results as $result) {
            $monthIndex = $result->month - 1;
            $electricData[$monthIndex] = (float)$result->electric;
            $waterData[$monthIndex] = (float)$result->water;
            $garbageData[$monthIndex] = (float)$result->garbage;
        }

        return [
            'electric' => $electricData,
            'water' => $waterData,
            'garbage' => $garbageData
        ];
    }

    public function filterRevenue(Request $request)
    {
        $user = auth()->user();
        $year = $request->year ?? date('Y');
        $month = $request->month ?? null;

        $data = $this->getMonthlyRevenue($user, $year, $month);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function filterExpense(Request $request)
    {
        $user = auth()->user();
        $year = $request->year ?? date('Y');
        $month = $request->month ?? null;

        $data = $this->getMonthlyExpense($user, $year, $month);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
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

    public function getMonthlyExpenseByYear(Request $request, $year)
    {
        $user = auth()->user();
        $monthlyExpenseData = $this->getMonthlyExpense($user, $year);
        
        return response()->json([
            'success' => true,
            'data' => $monthlyExpenseData,
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

    public function getMonthlyExpenseData(Request $request)
    {
        $user = auth()->user();
        $year = $request->get('year', date('Y'));
        $monthlyExpenseData = $this->getMonthlyExpense($user, $year);
        
        return response()->json([
            'success' => true,
            'data' => $monthlyExpenseData,
            'year' => $year
        ]);
    }
}
