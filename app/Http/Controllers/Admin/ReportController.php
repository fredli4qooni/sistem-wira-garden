<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    private function getFilterDates($period, $startDate, $endDate)
    {
        $start = null;
        $end = null;

        if ($period == 'this_month') {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        } elseif ($period == 'last_month') {
            $start = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $end = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        } elseif ($period == 'this_year') {
            $start = Carbon::now()->startOfYear()->format('Y-m-d');
            $end = Carbon::now()->endOfYear()->format('Y-m-d');
        } elseif ($period == 'custom' && $startDate && $endDate) {
            $start = $startDate;
            $end = $endDate;
        } else {
            // Default: this month
            $start = Carbon::now()->startOfMonth()->format('Y-m-d');
            $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        return [$start, $end];
    }

    private function getFilteredQuery($start, $end)
    {
        return Order::with('items.destination')
            ->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
    }

    public function index(Request $request)
    {
        $period = $request->input('period', 'this_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        list($start, $end) = $this->getFilterDates($period, $startDate, $endDate);

        $query = $this->getFilteredQuery($start, $end);
        $orders = $query->latest()->get();

        // 1. Summary Cards
        $totalReservations = $orders->count();
        $totalVisitors = $orders->sum(function($order) {
            return $order->items->sum('quantity');
        });
        $successfulReservations = $orders->whereIn('status', ['PAID', 'CONFIRMED', 'COMPLETED'])->count();
        $totalRevenue = $orders->whereIn('status', ['PAID', 'CONFIRMED', 'COMPLETED'])->sum('total_amount');

        // 2. Chart Data: Reservations per day
        $reservationsPerDay = $orders->groupBy(function($order) {
            return Carbon::parse($order->created_at)->format('d M');
        })->map(function($dayOrders) {
            return $dayOrders->count();
        });

        // Fill missing days in the range if it's not too long (optional, skipping for simplicity)
        // Ensure chronological order
        $reservationsPerDay = $reservationsPerDay->sortKeys();

        // 3. Chart Data: Status
        $statusCounts = [
            'Menunggu' => $orders->where('status', 'PENDING')->count() + $orders->where('status', 'PAID')->count(),
            'Dikonfirmasi' => $orders->where('status', 'CONFIRMED')->count(),
            'Selesai' => $orders->where('status', 'COMPLETED')->count(),
            'Dibatalkan' => $orders->where('status', 'CANCELLED')->count(),
        ];

        return view('admin.reports.index', compact(
            'period', 'start', 'end', 'orders',
            'totalReservations', 'totalVisitors', 'successfulReservations', 'totalRevenue',
            'reservationsPerDay', 'statusCounts'
        ));
    }

    public function exportPdf(Request $request)
    {
        $period = $request->input('period', 'this_month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        list($start, $end) = $this->getFilterDates($period, $startDate, $endDate);
        
        $orders = $this->getFilteredQuery($start, $end)->latest()->get();
        
        $totalReservations = $orders->count();
        $totalVisitors = $orders->sum(function($order) {
            return $order->items->sum('quantity');
        });
        $successfulReservations = $orders->whereIn('status', ['PAID', 'CONFIRMED', 'COMPLETED'])->count();
        $totalRevenue = $orders->whereIn('status', ['PAID', 'CONFIRMED', 'COMPLETED'])->sum('total_amount');

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'orders', 'start', 'end', 
            'totalReservations', 'totalVisitors', 'successfulReservations', 'totalRevenue'
        ))->setPaper('a4', 'landscape');
                  
        return $pdf->download("Laporan_Reservasi_{$start}_to_{$end}.pdf");
    }
}
