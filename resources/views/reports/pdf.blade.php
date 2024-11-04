<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Financiero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }
        .summary {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #2c3e50;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-success {
            color: #2ecc71;
        }
        .text-danger {
            color: #e74c3c;
        }
        .section {
            margin-bottom: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .chart-box {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px auto;
            background-color: white;
            border-radius: 5px;
        }
        .chart-title {
            text-align: center;
            margin-bottom: 15px;
            color: #2c3e50;
            font-weight: bold;
        }
        .distribution-bar {
            width: 100%;
            height: 40px;
            background-color: #f8f9fa;
            margin: 15px 0;
            border: 1px solid #ddd;
            position: relative;
        }
        .income-bar {
            height: 100%;
            background-color: #2ecc71;
            float: left;
        }
        .expense-bar {
            height: 100%;
            background-color: #e74c3c;
            float: left;
        }
        .chart-legend {
            margin-top: 15px;
            text-align: center;
        }
        .legend-item {
            display: inline-block;
            margin: 0 15px;
            padding: 5px;
        }
        .legend-color {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }
        .legend-label {
            display: inline;
            vertical-align: middle;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .summary-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Financiero</h1>
        <p>Período: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Resumen General</h2>

        <div class="summary-box">
            <div class="summary-item">
                <strong>Total Ingresos:</strong> 
                <span class="text-success">${{ number_format($totalIncomes, 2) }}</span>
            </div>
            <div class="summary-item">
                <strong>Total Gastos:</strong> 
                <span class="text-danger">${{ number_format($totalExpenses, 2) }}</span>
            </div>
            <div class="summary-item">
                <strong>Balance:</strong> 
                <span class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
                    ${{ number_format($balance, 2) }}
                </span>
            </div>
        </div>

        <div class="chart-box">
            <div class="chart-title">Distribución de Ingresos vs Gastos</div>
            @php
                $total = $totalIncomes + $totalExpenses;
                $incomesPercentage = $total > 0 ? ($totalIncomes / $total) * 100 : 0;
                $expensesPercentage = $total > 0 ? ($totalExpenses / $total) * 100 : 0;
            @endphp

            <div class="distribution-bar">
                <div class="income-bar" style="width: {{ $incomesPercentage }}%"></div>
                <div class="expense-bar" style="width: {{ $expensesPercentage }}%"></div>
            </div>

            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #2ecc71"></div>
                    <span class="legend-label">Ingresos ({{ number_format($incomesPercentage, 1) }}%)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #e74c3c"></div>
                    <span class="legend-label">Gastos ({{ number_format($expensesPercentage, 1) }}%)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Detalle de Ingresos</h2>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th class="text-right">Monto</th>
                    <th class="text-right">Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomesData as $type => $amount)
                <tr>
                    <td>{{ $type }}</td>
                    <td class="text-right">${{ number_format($amount, 2) }}</td>
                    <td class="text-right">
                        {{ $totalIncomes > 0 ? number_format(($amount / $totalIncomes) * 100, 1) : 0 }}%
                    </td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total Ingresos</td>
                    <td class="text-right">${{ number_format($totalIncomes, 2) }}</td>
                    <td class="text-right">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2 class="section-title">Detalle de Gastos</h2>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th class="text-right">Monto</th>
                    <th class="text-right">Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expensesData as $type => $amount)
                <tr>
                    <td>{{ $type }}</td>
                    <td class="text-right">${{ number_format($amount, 2) }}</td>
                    <td class="text-right">
                        {{ $totalExpenses > 0 ? number_format(($amount / $totalExpenses) * 100, 1) : 0 }}%
                    </td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total Gastos</td>
                    <td class="text-right">${{ number_format($totalExpenses, 2) }}</td>
                    <td class="text-right">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Reporte generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>