<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
<div class="header">
    <h1>Invoice</h1>
    <p>Date: {{ $date }}</p>
</div>
<h2>Client: {{ $client->name }}</h2>
<p>Email: {{ $client->email }}</p>
<p>Project: {{ $project->name }}</p>

<table class="table">
    <thead>
    <tr>
        <th>Task</th>
        <th>Description</th>
        <th>Cost</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description ?? 'N/A' }}</td>
            <td>${{ number_format($task->cost, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">Total</td>
        <td>${{ number_format($totalCost, 2) }}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>