<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $totalInvoices = $user->invoices()->count();
        $outstandingAmount = $user->invoices()
            ->whereIn('status', ['sent', 'viewed', 'overdue'])
            ->sum('total');
        $overdueCount = $user->invoices()->where('status', 'overdue')->count();
        $paidAmount = $user->invoices()->where('status', 'paid')->sum('total');
        $totalClients = $user->clients()->count();

        $recentInvoices = $user->invoices()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = InvoiceActivity::whereHas('invoice', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('invoice')->latest()->take(10)->get();

        return view('dashboard', compact(
            'totalInvoices',
            'outstandingAmount',
            'overdueCount',
            'paidAmount',
            'totalClients',
            'recentInvoices',
            'recentActivities'
        ));
    }
}
