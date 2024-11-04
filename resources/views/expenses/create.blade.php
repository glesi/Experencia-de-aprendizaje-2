@extends('layouts.app')

@section('title', 'Registrar Salida')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Registrar Nueva Salida</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expense_type_id" class="form-label">Tipo de Salida</label>
                            <select class="form-select @error('expense_type_id') is-invalid @enderror" 
                                    id="expense_type_id" name="expense_type_id" required>
                                <option value="">Seleccione un tipo...</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('expense_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('expense_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                       id="amount" name="amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="invoice" class="form-label">Factura (Opcional)</label>
                            <input type="file" class="form-control @error('invoice') is-invalid @enderror"
                                   id="invoice" name="invoice" accept="image/*">
                            @error('invoice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notas (Opcional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror"
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Registrar Salida</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection