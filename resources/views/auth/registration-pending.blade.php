<x-guest-layout>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: #f4f7fc;
        }

        .verify-card {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .verify-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #333;
        }

        .pending-box {
            background: #fff3cd;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ffe69c;
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="verify-card text-center" style="max-width: 480px; width:100%;">
             <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up! Before getting started, please verify your email address
        by clicking on the link we just emailed to you. If you didn't receive the email,
        we will gladly send you another.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            A new verification link has been sent to the email address you provided.
        </div>
    @endif
            <hr class="my-4">

            <div class="pending-box mb-3">
                <h5 class="text-warning fw-bold mb-2">
                    ⏳ Registration Pending
                </h5>
                <p class="text-muted mb-0">
                    Your account will be activated once the admin approves it.
                </p>
            </div>

            <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2 w-100">
                Return to Login
            </a>

        </div>

    </div>

</x-guest-layout>
