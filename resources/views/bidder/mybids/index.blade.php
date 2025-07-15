<x-app-layout>
    <h2 class="text-2xl font-bold mb-6">💰 My Bids</h2>

    <div class="bg-white rounded shadow p-4">
        @if($bids->count() > 0)
            <table class="w-full text-sm table-auto">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">Product</th>
                        <th class="p-3">Your Bid</th>
                        <th class="p-3">Auction Ends</th>
                        <th class="p-3">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bids as $bid)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-semibold">{{ $bid->product->item_name }}</td>
                            <td class="p-3 text-green-600 font-bold">₹{{ number_format($bid->amount, 2) }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($bid->product->end_time)->format('d M Y, h:i A') }}</td>
                            <td class="p-3">{{ $bid->updated_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">You have not placed any bids yet.</p>
        @endif
    </div>
</x-app-layout>
