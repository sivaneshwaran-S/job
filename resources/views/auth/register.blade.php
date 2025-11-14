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

    /* RIGHT FORM — center everything */
    .register-container {
        width: 100%;
        padding: 40px 35px;
        display: flex;
        align-items: center;       /* vertical centering */
        justify-content: center;   /* horizontal centering of inner form box */
    }

    /* inner form box to control width of inputs */
    .register-form-box {
        width: 100%;
        max-width: 480px; /* control input width so it's not edge-to-edge */
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

    .form-control:focus {
        border-color: #4e73df;
        outline: none;
        box-shadow: 0 0 0 3px rgba(78,115,223,0.12);
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

    .login-link {
        text-align: center;
        margin-top: 14px;
        font-size: 14px;
    }
    .login-link a {
        color: #4e73df;
        font-weight: 600;
    }

    /* Responsive: stack and hide image on small screens */
    @media (max-width: 900px) {
        .register-img { display: none; }
        .register-container { width: 100%; padding: 30px 20px; }
        .register-wrapper { border-radius: 12px; max-width: 95%; }
    }
</style>

<div class="register-wrapper">

    <!-- LEFT IMAGE: replace path with your image in public/images/ -->
    <div class="register-img" style="background-image: url('{{ asset('images/register-side.jpg') }}');"></div>

    <!-- RIGHT FORM -->
    <div class="register-container">
        <div class="register-form-box">
            <div class="register-title">Create Account</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone" type="text" class="form-control" name="phone">
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" type="text" class="form-control" name="location">
                </div>

                <div class="form-group">
                    <label for="role">Register As</label>
                    <select id="role" class="form-control" name="role" required>
                        <option value="">-- Select --</option>
                        <option value="employee">Job Seeker</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>

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

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-register">Register</button>

                <div class="login-link">
                    Already registered? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // toggle employer fields
    document.getElementById('role').addEventListener('change', function() {
        document.getElementById('employer_fields').style.display =
            this.value === 'employer' ? 'block' : 'none';
    });
</script>

</x-guest-layout>
