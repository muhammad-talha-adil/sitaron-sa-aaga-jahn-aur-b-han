@extends('layout.master')
@section('page_title', '404 - Page Not Found')
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h1 class="display-1 fw-bold text-gray-800">404</h1>
                        <h2 class="fw-bold text-gray-800">Page Not Found</h2>
                        <p class="text-muted fs-4">The page you are looking for doesn't exist.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection