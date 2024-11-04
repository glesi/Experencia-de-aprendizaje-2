@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-0">¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Panel de Control de Finanzas</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card income">
                <i class='bx bx-money mb-3' style="font-size: 2rem;"></i>
                <h6>Total Ingresos</h6>
                <div class="stats-value text-success">
                    ${{ number_format($totalIncomes, 2) }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card expense">
                <i class='bx bx-shopping-bag mb-3' style="font-size: 2rem;"></i>
                <h6>Total Gastos</h6>
                <div class="stats-value text-danger">
                    ${{ number_format($totalExpenses, 2) }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card balance">
                <i class='bx bx-wallet mb-3' style="font-size: 2rem;"></i>
                <h6>Balance</h6>
                <div class="stats-value {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                    ${{ number_format($balance, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('incomes.create') }}" class="btn btn-primary w-100">
                                <i class='bx bx-plus-circle'></i> Nuevo Ingreso
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('expenses.create') }}" class="btn btn-danger w-100">
                                <i class='bx bx-minus-circle'></i> Nuevo Gasto
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('reports.index') }}" class="btn btn-info w-100 text-white">
                                <i class='bx bx-line-chart'></i> Ver Reportes
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('incomes.index') }}" class="btn btn-secondary w-100">
                                <i class='bx bx-list-ul'></i> Ver Movimientos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Sistema</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total de Movimientos
                            <span class="badge bg-primary rounded-pill">
                                {{ \App\Models\Income::where('user_id', auth()->id())->count() + 
                                   \App\Models\Expense::where('user_id', auth()->id())->count() }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ingresos Registrados
                            <span class="badge bg-success rounded-pill">
                                {{ \App\Models\Income::where('user_id', auth()->id())->count() }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Gastos Registrados
                            <span class="badge bg-danger rounded-pill">
                                {{ \App\Models\Expense::where('user_id', auth()->id())->count() }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection