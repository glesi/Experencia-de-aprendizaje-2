@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">¡Bienvenido, {{ Auth::user()->name }}!</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Entradas</h5>
                    <h2 class="text-success">${{ number_format($totalIncomes, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Salidas</h5>
                    <h2 class="text-danger">${{ number_format($totalExpenses, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <h2 class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                        ${{ number_format($balance, 2) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Últimas Entradas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->incomes()->latest()->take(5)->get() as $income)
                                <tr>
                                    <td>{{ $income->date->format('d/m/Y') }}</td>
                                    <td>{{ $income->type->name }}</td>
                                    <td>${{ number_format($income->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Últimas Salidas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->expenses()->latest()->take(5)->get() as $expense)
                                <tr>
                                    <td>{{ $expense->date->format('d/m/Y') }}</td>
                                    <td>{{ $expense->type->name }}</td>
                                    <td>${{ number_format($expense->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection