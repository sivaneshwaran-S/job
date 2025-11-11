<x-guest-layout>
    <div class="max-w-md mx-auto mt-20 bg-white shadow-md rounded-lg p-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Registration Pending Approval</h1>
        <p class="text-gray-600 mb-6">
            Your registration was successful, but your account is awaiting admin approval.
        </p>
        <p class="text-gray-600">
            You will be able to log in once your account is approved.
        </p>

        <div class="mt-6">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Return to Login</a>
        </div>
    </div>
</x-guest-layout>
