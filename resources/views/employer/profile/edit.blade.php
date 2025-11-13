@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-bold">Company Profile</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('employer.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Company Name</label>
                    <input type="text" name="company_name"
                        value="{{ old('company_name', $employer->company_name) }}"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Industry Type</label>
                    <input type="text" name="industry_type"
                        value="{{ old('industry_type', $employer->industry_type) }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Website</label>
                    <input type="url" name="website"
                        value="{{ old('website', $employer->website) }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">GST Number</label>
                    <input type="text" name="gst_number"
                        value="{{ old('gst_number', $employer->gst_number) }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Address</label>
                    <textarea name="address" rows="3"
                        class="form-control">{{ old('address', $employer->address) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
