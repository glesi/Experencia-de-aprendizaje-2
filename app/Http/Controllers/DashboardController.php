<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncomes = Income::where('user_id', auth()->id())->sum('amount');
        $totalExpenses = Expense::where('user_id', auth()->id())->sum('amount');
        $balance = $totalIncomes - $totalExpenses;

        return view('dashboard', compact('totalIncomes', 'totalExpenses', 'balance'));
    }
}