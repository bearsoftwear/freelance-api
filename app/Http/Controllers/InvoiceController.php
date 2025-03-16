<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    public function generate(Project $project)
    {
        Gate::authorize('view', $project);

        $task = $project->tasks()->where('status', 'completed')->get();
        $totalCost = $task->sum('cost');

        $data = [
            'project' => $project,
            'client' => $project->client,
            'tasks' => $task,
            'totalCost' => $totalCost,
            'date' => now()->format('D, d F Y'),
        ];

        $pdf = Pdf::loadView('invoice', $data);
        // return $pdf->stream('invoice_project_' . $project->id . '.pdf');
        return $pdf->download('invoice_project_' . $project->id . '.pdf');
    }
}
