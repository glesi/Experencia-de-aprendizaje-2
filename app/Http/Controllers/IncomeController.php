<?php
namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('type')
            ->where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        $types = IncomeType::all();
        return view('incomes.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'income_type_id' => 'required|exists:income_types,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'invoice' => 'nullable|image|max:2048', 
            'notes' => 'nullable|string'
        ]);

        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('public/invoices/incomes');
            $validated['invoice_path'] = str_replace('public/', '', $path);
        }

        $validated['user_id'] = auth()->id();
        Income::create($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Ingreso registrado exitosamente.');
    }
}