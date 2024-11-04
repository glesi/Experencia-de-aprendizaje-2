<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);
        return view('reports.index', $data);
    }

    public function export(Request $request)
    {
        $data = $this->getReportData($request);
        $pdf = PDF::loadView('reports.pdf', $data);
        return $pdf->download('reporte-financiero.pdf');
    }

    private function getReportData(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $incomes = Income::with('type')
            ->where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $expenses = Expense::with('type')
            ->where('user_id', auth()->id())
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalIncomes = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $balance = $totalIncomes - $totalExpenses;

        //  datos para la parte del gráfico
        $incomesData = $incomes->groupBy('type.name')
            ->map(fn($group) => $group->sum('amount'));
        $expensesData = $expenses->groupBy('type.name')
            ->map(fn($group) => $group->sum('amount'));

        return compact(
            'incomes', 
            'expenses', 
            'totalIncomes', 
            'totalExpenses', 
            'balance', 
            'startDate', 
            'endDate',
            'incomesData',
            'expensesData'
        );
    }
}