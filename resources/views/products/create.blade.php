@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-5">
            <a href="{{ route('products.index') }}" class="text-decoration-none text-muted small fw-600">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
            <h1 class="fw-800 mt-3">Add New Product</h1>
            <p class="text-muted">Fill in the details to list a new item in your inventory.</p>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-600 extra-small text-uppercase text-muted">Product Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g. Wireless Headphones" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-600 extra-small text-uppercase text-muted">Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-600 extra-small text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" placeholder="Briefly describe the product features...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-600 extra-small text-uppercase text-muted">Price (USD)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-dollar-sign small"></i></span>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                            @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 extra-small text-uppercase text-muted">Initial Stock</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-boxes small"></i></span>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                       value="{{ old('stock', 0) }}" placeholder="0" required>
                            </div>
                            @error('stock')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch bg-light p-3 rounded-3 border">
                            <input type="hidden" name="enabled" value="0">
                            <input class="form-check-input ms-0 me-3" type="checkbox" name="enabled" id="enabled" 
                                   value="1" {{ old('enabled', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-600" for="enabled">Enable this product immediately</label>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-save me-2"></i>Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .fw-600 { font-weight: 600; }
    .extra-small { font-size: 0.7rem; }
    .is-invalid { border-color: #ef4444 !important; }
</style>
@endsection