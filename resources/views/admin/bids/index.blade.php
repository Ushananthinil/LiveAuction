<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">📢 All Live Bids</h2>
    </x-slot>

    <table class="w-full mt-5 table-auto border-collapse border" id="bids-table">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Product</th>
                <th class="border p-2">Bidder</th>
                <th class="border p-2">Amount</th>
                <th class="border p-2">Placed At</th>
            </tr>
        </thead>
        <tbody id="bids-body">
            @forelse($bids as $bid)
                <tr>
                    <td class="border p-2">{{ $bid->product->item_name }}</td>
                    <td class="border p-2">{{ $bid->user->name }}</td>
                    <td class="border p-2">₹{{ number_format($bid->amount, 2) }}</td>
                    <td class="border p-2">{{ $bid->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border p-2 text-center">No bids yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pusher Script --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('local', {
            cluster: 'mt1',
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false,
        });

        const channel = pusher.subscribe('admin-auction-channel');

        channel.bind('bid.placed', function(data) {
            let newRow = `
                <tr>
                    <td class="border p-2">${data.bid.product.item_name}</td>
                    <td class="border p-2">${data.bid.user.name}</td>
                    <td class="border p-2">₹${parseFloat(data.bid.amount).toFixed(2)}</td>
                    <td class="border p-2">Just Now</td>
                </tr>
            `;
            document.getElementById('bids-body').insertAdjacentHTML('afterbegin', newRow);
        });
    </script>
</x-app-layout>
