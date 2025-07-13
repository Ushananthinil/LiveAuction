<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            ✏️ Edit Product
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white shadow-md rounded-lg p-8">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Item Name -->
            <div class="mb-4">
                <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                <input type="text" name="item_name" id="item_name" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                    value="{{ old('item_name', $product->item_name) }}">
            </div>

            <!-- Starting Bid -->
            <div class="mb-4">
                <label for="starting_bid" class="block text-sm font-medium text-gray-700">Starting Bid ($)</label>
                <input type="number" name="starting_bid" id="starting_bid" required step="0.01"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                    value="{{ old('starting_bid', $product->starting_bid) }}">
            </div>

            <!-- Start Time -->
            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                    value="{{ old('start_time', \Carbon\Carbon::parse($product->start_time)->format('Y-m-d\TH:i')) }}">
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2 px-3"
                    value="{{ old('end_time', \Carbon\Carbon::parse($product->end_time)->format('Y-m-d\TH:i')) }}">
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm border border-gray-300 rounded-md shadow-sm py-2 px-3">

                @if ($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-32 h-32 object-cover border rounded">
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-gray-100 text-gray-700 hover:bg-gray-200 transition px-4 py-2 rounded">
                    ⬅ Back
                </a>
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">
                    💾 Update Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
