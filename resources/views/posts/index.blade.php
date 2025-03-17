@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Scheduled Posts</h2>

    {{-- Table to display posts dynamically --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Platform</th>
                <th>Scheduled At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="postsTable">
            <tr>
                <td colspan="4" class="text-center">Loading posts...</td>
            </tr>
        </tbody>
    </table>

    {{-- Analytics Chart --}}
    <h3 class="mt-5">Post Analytics</h3>
    <canvas id="postChart"></canvas>
</div>

{{-- Fetch API and Display Data --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("{{ url('/api/posts') }}")  // Use your existing API route
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("postsTable");
            tableBody.innerHTML = ""; // Clear default row

            data.forEach(post => {
                let statusBadge = post.status === "published" ?
                    '<span class="badge bg-success">Published</span>' :
                    '<span class="badge bg-warning">Scheduled</span>';

                tableBody.innerHTML += `
                    <tr>
                        <td>${post.title}</td>
                        <td>${post.platform}</td>
                        <td>${post.scheduled_at}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
            });
        });

    // Fetch and Render Chart Data
    let ctx = document.getElementById('postChart').getContext('2d');
    fetch("{{ url('/api/posts/analytics') }}")
        .then(response => response.json())
        .then(data => {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Scheduled', 'Published'],
                    datasets: [{
                        label: 'Posts',
                        data: [data.scheduled, data.published],
                        backgroundColor: ['#FFC107', '#28A745']
                    }]
                }
            });
        });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
