
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Reporte de Balance</h5>
            <div>
                <button onclick="window.print()" class="btn btn-secondary me-2">
                    <i class='bx bx-printer'></i> Imprimir
                </button>
                <a href="{{ route('reports.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                   class="btn btn-primary">
                    <i class='bx bx-download'></i> Exportar PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <form id="reportForm" class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" name="end_date" class="form-control"
                           value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>

            <div class="row">
                <div class="col-md-6">
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h6>Total Ingresos</h6>
                                <div class="stats-value text-success">
                                    ${{ number_format($totalIncomes, 2) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h6>Total Gastos</h6>
                                <div class="stats-value text-danger">
                                    ${{ number_format($totalExpenses, 2) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h6>Balance</h6>
                                <div class="stats-value {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                                    ${{ number_format($balance, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-end">Monto</th>
                                    <th class="text-end">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes->groupBy('type.name') as $type => $groupedIncomes)
                                    <tr>
                                        <td>{{ $type }}</td>
                                        <td class="text-end">${{ number_format($groupedIncomes->sum('amount'), 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format(($groupedIncomes->sum('amount') / $totalIncomes) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <th>Total Ingresos</th>
                                    <th class="text-end">${{ number_format($totalIncomes, 2) }}</th>
                                    <th class="text-end">100%</th>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-end">Monto</th>
                                    <th class="text-end">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses->groupBy('type.name') as $type => $groupedExpenses)
                                    <tr>
                                        <td>{{ $type }}</td>
                                        <td class="text-end">${{ number_format($groupedExpenses->sum('amount'), 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format(($groupedExpenses->sum('amount') / $totalExpenses) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <th>Total Gastos</th>
                                    <th class="text-end">${{ number_format($totalExpenses, 2) }}</th>
                                    <th class="text-end">100%</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ingresos', 'Gastos'],
            datasets: [{
                data: [{{ $totalIncomes }}, {{ $totalExpenses }}],
                backgroundColor: ['#2ecc71', '#e74c3c'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Balance de Ingresos vs Gastos'
                }
            }
        }
    });
</script>
@endpush
@endsection