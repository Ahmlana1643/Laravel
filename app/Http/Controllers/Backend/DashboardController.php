<?php
namespace App\Http\Controllers\Backend;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve and calculate transaction statistics
        $firstTransactionDate = Transaction::orderBy('created_at', 'asc')->value('created_at');
        $lastTransactionDate = Transaction::orderBy('created_at', 'desc')->value('created_at');
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $failedTransactions = Transaction::where('status', 'failed')->count();
        $successTransactions = Transaction::where('status', 'success')->count();
        $transactions = Transaction::latest()->limit(5)->get();

        // Retrieve the latest 5 transactions
        $latestTransactions = Transaction::orderBy('created_at', 'desc')->take(5)->get();

        return view('backend.dashboard.index', compact(
            
            'firstTransactionDate',
            'lastTransactionDate',
            'totalTransactions',
            'pendingTransactions',
            'failedTransactions',
            'successTransactions',
            'latestTransactions',
            'transactions'
        ));
    }
}

