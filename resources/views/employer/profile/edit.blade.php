@extends('admin.layouts.app')

@section('content')

<style>
    /* ------------------------------
        PREMIUM UI VARIABLES
        Matches your sidebar theme
    ------------------------------ */
    :root {
        --navy-dark: #222e3c;
        --blue: #0d6efd;
        --blue-dark: #0b5ed7;
        --border: #d9e0e7;
        --bg-soft: #f7f9fc;
    }

    /* Smooth fade animation */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .premium-title {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--navy-dark);
        animation: fadeUp .4s ease;
    }

    /* PREMIUM CARD */
    .premium-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid var(--border);
        padding: 28px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        animation: fadeUp .5s ease;
    }

    /* LABELS */
    .form-label {
        font-weight: 600;
        color: var(--navy-dark);
    }

    /* PREMIUM INPUTS */
    .premium-input {
        border-radius: 10px;
        border: 1px solid var(--border);
        padding: 10px 14px;
        transition: 0.25s;
        background: #fff;
    }

    .premium-input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
    }

    /* TEXTAREA */
    textarea.premium-input {
        resize: none;
    }

    /* SAVE BUTTON */
    .save-btn {
        background: var(--blue);
        border: none;
        padding: 10px 28px;
        font-size: 1rem;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.25s;
    }

    .save-btn:hover {
        background: var(--blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    }
</style>



<div class="container-fluid py-4">

    <h2 class="premium-title mb-4">
        <i class="bi bi-building me-2 text-primary"></i>
        Company Profile
    </h2>

    @if (session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif


    <div class="premium-card">

        <form method="POST" action="{{ route('employer.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name"
                    value="{{ old('company_name', $employer->company_name) }}"
                    class="form-control premium-input" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Industry Type</label>
                <input type="text" name="industry_type"
                    value="{{ old('industry_type', $employer->industry_type) }}"
                    class="form-control premium-input">
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="url" name="website"
                    value="{{ old('website', $employer->website) }}"
                    class="form-control premium-input">
            </div>

            <div class="mb-3">
                <label class="form-label">GST Number</label>
                <input type="text" name="gst_number"
                    value="{{ old('gst_number', $employer->gst_number) }}"
                    class="form-control premium-input">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" rows="3"
                    class="form-control premium-input">{{ old('address', $employer->address) }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="save-btn">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
