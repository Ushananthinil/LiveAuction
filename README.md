# Live Auction Platform (Laravel)

- Authentication (Admin & Bidder)
- Product CRUD (Admin)
- Live Bidding (Pusher/AJAX fallback)
- Live Countdown Timer
- Real-time Chat
- YouTube Live Streaming
- My Bids Section

## How to Run Locally
1. Clone Repo
2. `composer install`
3. `npm install && npm run dev`
4. Setup `.env` (DB credentials)
5. `php artisan migrate --seed`
6. Start server: `php artisan serve`

## Admin Credentials:
- **Email:** admin@gmail.com
- **Password:** password

## Bidder Credentials:
- **Email:** bidder@gmail.com
- **Password:** password

---

## 📌 Important Notes
- Real-time handled via Laravel WebSockets / AJAX
- Easy upgrade possible for production (Pusher/WebSockets)
