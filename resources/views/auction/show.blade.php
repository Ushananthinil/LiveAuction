<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">

        <h1 class="text-2xl font-bold mb-4">{{ $product->item_name }}</h1>

        {{-- Live Streaming --}}
        <iframe width="100%" height="400"
                src="https://www.youtube.com/embed/{{ $product->youtube_live_id }}?autoplay=1"
                frameborder="0" allowfullscreen class="rounded-md shadow"></iframe>

        {{-- Countdown Timer --}}
        <div class="mt-4 text-lg font-semibold text-red-600" id="timer"></div>

        {{-- Highest Bid --}}
        <div class="mt-4 text-xl font-bold">
            Highest Bid: ₹<span id="highestBid">{{ number_format($highestBid, 2) }}</span>
        </div>

        {{-- Bid Form --}}
        <form id="bidForm" class="mt-6 flex gap-3">
            @csrf
            <input type="number" name="amount" id="amount" class="border p-2 rounded w-1/2" placeholder="Enter your bid" required>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
                ✅ Place Bid
            </button>
        </form>

        {{-- Live Bids --}}
        <div id="bidsList" class="mt-6 p-4 bg-white rounded shadow">
            <h3 class="font-bold text-lg mb-3">📝 Live Bids</h3>
        </div>

        {{-- Chat Box --}}
        <div class="mt-6 bg-gray-100 p-4 rounded">
            <h3 class="font-bold mb-2">💬 Live Chat</h3>
            <div id="chat-box" class="h-48 overflow-y-auto bg-white p-2 rounded mb-3"></div>
            <div class="flex gap-3">
                <input type="text" id="chat-message" placeholder="Type a message" class="border p-2 rounded w-2/3">
              
            <button id="send-message" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                💬 Send
            </button>
            </div>
        </div>

    </div>

    {{-- Pusher Script --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const productId = {{ $product->id }};
        const endTime = new Date("{{ \Carbon\Carbon::parse($product->end_time)->format('Y-m-d H:i:s') }}").getTime();

        // Countdown Timer
        setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;
            const timer = document.getElementById('timer');

            if (distance < 0) {
                timer.innerHTML = "❌ Auction Ended";
            } else {
                const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((distance % (1000 * 60)) / 1000);
                timer.innerHTML = `⏰ ${mins} minutes ${secs} seconds remaining`;
            }
        }, 1000);

        // Pusher Setup
        const pusher = new Pusher("local", {
            cluster: "mt1",
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false
        });

        const auctionChannel = pusher.subscribe('auction-channel-' + productId);

        auctionChannel.bind('bid.placed', function(data){
            alert('New Bid ₹' + data.bid.amount);
            document.getElementById('highestBid').innerText = parseFloat(data.bid.amount).toFixed(2);
            fetchBids();
        });

        // Fetch Bids List
        function fetchBids() {
            fetch("/bids/fetch/" + productId)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    data.forEach(bid => {
                        html += `<div><b>${bid.user.name}</b> — ₹${parseFloat(bid.amount).toFixed(2)}</div>`;
                    });
                    document.getElementById('bidsList').innerHTML = html;
                });
        }
        fetchBids();

        // Submit Bid
        document.getElementById('bidForm').addEventListener('submit', function(e){
            e.preventDefault();
            fetch("/bid/" + productId, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({amount: document.getElementById('amount').value})
            })
            .then(res => res.json())
            .then(res => {
                alert(res.message);
                document.getElementById('amount').value = '';
            });
        });

        // Chat Feature (optional)
        const chatChannel = pusher.subscribe('chat-channel');
        chatChannel.bind('chat.sent', function(data){
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += `<div><b>${data.user.name}:</b> ${data.message}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        });

        document.getElementById('send-message').addEventListener('click', function(){
            fetch("/chat/send", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    message: document.getElementById('chat-message').value,
                    product_id: productId
                })
            });
            document.getElementById('chat-message').value = '';
        });
    </script>

</x-app-layout>
