
@extends('layouts.app')

@section('title', 'Lista de Gastos')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Gastos</h5>
            <a href="{{ route('expenses.create') }}" class="btn btn-danger">
                <i class='bx bx-plus'></i> Nuevo Gasto
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                            <th>Factura</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->date->format('d/m/Y') }}</td>
                                <td>{{ $expense->type->name }}</td>
                                <td class="text-danger">${{ number_format($expense->amount, 2) }}</td>
                                <td>
                                    @if($expense->invoice_path)
                                        <a href="#" class="view-invoice" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#invoiceModal"
                                           data-title="Gasto: {{ $expense->type->name }} - {{ $expense->date->format('d/m/Y') }}"
                                           data-image="{{ Storage::url($expense->invoice_path) }}">
                                            <img src="{{ Storage::url($expense->invoice_path) }}" 
                                                 alt="Factura" 
                                                 class="img-thumbnail" 
                                                 style="height: 50px; width: 50px; object-fit: cover;">
                                        </a>
                                    @else
                                        <span class="text-muted">Sin factura</span>
                                    @endif
                                </td>
                                <td>{{ $expense->notes ?? 'Sin notas' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay gastos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $expenses->links() }}
        </div>
    </div>
</div>


<div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="invoiceImage" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.view-invoice').forEach(button => {
    button.addEventListener('click', function() {
        const image = this.dataset.image;
        const title = this.dataset.title;
        document.getElementById('invoiceImage').src = image;
        document.querySelector('#invoiceModal .modal-title').textContent = title;
    });
});
</script>
@endpush
@endsection