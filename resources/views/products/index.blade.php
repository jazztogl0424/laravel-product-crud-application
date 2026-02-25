@extends('layouts.app')

@section('content')
    <div class="row align-items-center mb-5">
        <div class="col">
            <h1 class="fw-800 mb-0">Products</h1>
            <p class="text-muted">Manage your inventory and product listings.</p>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('api.products.export') }}" class="btn btn-outline-dark shadow-sm">
                    <i class="fas fa-file-excel me-2"></i>Export
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-2"></i>Add Product
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-600 extra-small text-uppercase text-muted mb-2">Category</label>
                    <select name="category_id" class="form-select shadow-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-600 extra-small text-uppercase text-muted mb-2">Status</label>
                    <select name="status" class="form-select shadow-none">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Enabled</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Disabled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 py-2">
                            <i class="fas fa-filter me-2 small"></i>Apply Filters
                        </button>
                        @if(request()->anyFilled(['category_id', 'status']))
                            <a href="{{ route('products.index') }}" class="btn btn-light border py-2">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded p-2 me-3">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="fw-600 text-dark">{{ $product->name }}</div>
                                            <div class="extra-small text-muted">ID: #{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $product->category->name }}</span>
                                </td>
                                <td>
                                    <div class="fw-600">${{ number_format($product->price, 2) }}</div>
                                </td>
                                <td>
                                    <div class="small {{ $product->stock <= 5 ? 'text-danger fw-bold' : '' }}">
                                        {{ $product->stock }} units
                                    </div>
                                </td>
                                <td>
                                    @if($product->enabled)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="fas fa-circle extra-small me-1"></i> Enabled
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="fas fa-circle extra-small me-1"></i> Disabled
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-none"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2">
                                            <li>
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="dropdown-item rounded py-2">
                                                    <i class="fas fa-edit me-2 text-primary"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider opacity-50">
                                            </li>
                                            <li>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                    onsubmit="return confirm('Archive this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item rounded py-2 text-danger">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-search fs-1 text-muted mb-3 d-block"></i>
                                    <p class="text-muted">No products found matching your criteria.</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-link">Clear all filters</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white border-0 py-4 px-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <style>
        .fw-800 {
            font-weight: 800;
        }

        .fw-600 {
            font-weight: 600;
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .bg-success-subtle {
            background-color: #dcfce7 !important;
        }

        .bg-danger-subtle {
            background-color: #fee2e2 !important;
        }

        .dropdown-item:active {
            background-color: var(--primary-color);
        }
    </style>
@endsection