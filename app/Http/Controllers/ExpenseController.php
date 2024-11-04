<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('type')
            ->where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $types = ExpenseType::all();
        return view('expenses.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'invoice' => 'nullable|image|max:2048', // max 2MB
            'notes' => 'nullable|string'
        ]);

        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('public/invoices/expenses');
            $validated['invoice_path'] = str_replace('public/', '', $path);
        }

        $validated['user_id'] = auth()->id();
        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Gasto registrado exitosamente.');
    }
}