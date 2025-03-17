@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Platform Settings</h2>

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="api_keys" class="form-label">Social Media API Keys:</label>
            <input type="text" name="api_keys" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
