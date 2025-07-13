<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">📦 Product List</h2>
    </x-slot>

    <div class="container">
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="action-bar">
            <h3 class="section-title">All Products</h3>
            <a href="{{ route('products.create') }}" class="btn-add">➕ Add Product</a>
        </div>

        <div class="table-wrapper">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Start Price</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->item_name }}</td>
                            <td>₹{{ number_format($product->starting_bid, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->start_time)->format('d M Y, h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->end_time)->format('d M Y, h:i A') }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="link-edit">✏️ Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline-form" onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="link-delete">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #444;
        }
        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .btn-add {
            background-color: #4f46e5;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-add:hover {
            background-color: #4338ca;
        }
        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .product-table th, .product-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .product-table thead {
            background-color: #f3f4f6;
        }
        .link-edit {
            color: #2563eb;
            margin-right: 10px;
            text-decoration: none;
        }
        .link-edit:hover {
            text-decoration: underline;
        }
        .link-delete {
            color: #dc2626;
            background: none;
            border: none;
            cursor: pointer;
        }
        .link-delete:hover {
            text-decoration: underline;
        }
        .inline-form {
            display: inline;
        }
        .text-center {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</x-app-layout>
