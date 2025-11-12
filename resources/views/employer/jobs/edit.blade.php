@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Job</h2>
    <form method="POST" action="{{ route('employer.jobs.update', $job->id) }}">
        @csrf
        @method('PUT')

        @include('employer.jobs.form-fields', ['job' => $job])

        <button class="btn btn-primary">Update Job</button>
        <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
