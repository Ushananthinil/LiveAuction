<x-app-layout>
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Welcome, {{ Auth::user()->name }}</h2>
            </div>
            <div class="card-body">
                <p class="lead">You are logged in as <strong>{{ Auth::user()->role }}</strong>.</p>
            </div>
        </div>
    </div>
</x-app-layout>
