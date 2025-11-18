<x-guest-layout>

<style>
    body {
        background: #f4f6f9;
    }

    .register-wrapper {
        display: flex;
        max-width: 500px;
        width: 100%;
        margin: 40px auto;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    }

    .register-container {
        width: 100%;
        padding: 40px 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-form-box {
        width: 100%;
        max-width: 480px;
    }

    .register-title {
        font-size: 26px;
        font-weight: 700;
        text-align: center;
        color: #4e73df;
        margin-bottom: 22px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .btn-register {
        background: #4e73df;
        color: #fff;
        border-radius: 8px;
        padding: 12px 18px;
        width: 100%;
        border: none;
        font-weight: 700;
    }

    .btn-register:hover {
        background: #3b5fd3;
    }
</style>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-form-box">
            <div class="register-title">Create Account</div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('status'))
                <div style="color: green; text-align:center; margin-bottom:10px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- FULL NAME --}}
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" class="form-control" name="name" required>
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>

                {{-- PHONE --}}
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone" type="text" class="form-control" name="phone">
                </div>

                {{-- LOCATION --}}
                <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" type="text" class="form-control" name="location">
                </div>

                {{-- ROLE --}}
                <div class="form-group">
                    <label for="role">Register As</label>
                    <select id="role" class="form-control" name="role" required>
                        <option value="">-- Select --</option>
                        <option value="employee">Job Seeker</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>

                {{-- EMPLOYER EXTRA FIELDS --}}
                <div id="employer_fields" style="display:none;">
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input id="company_name" type="text" class="form-control" name="company_name">
                    </div>

                    <div class="form-group">
                        <label for="website">Website URL</label>
                        <input id="website" type="url" class="form-control" name="website">
                    </div>

                    <div class="form-group">
                        <label for="address">Company Address</label>
                        <input id="address" type="text" class="form-control" name="address">
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                {{-- REGISTER BUTTON --}}
                <button type="submit" class="btn-register">
                    Register
                </button>

                <div class="login-link" style="margin-top:10px; text-align:center;">
                    Already registered? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Show employer fields on selection
    document.getElementById('role').addEventListener('change', function () {
        document.getElementById('employer_fields').style.display =
            this.value === 'employer' ? 'block' : 'none';
    });
</script>

</x-guest-layout>
