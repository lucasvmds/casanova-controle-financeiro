<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Extract\ShowRequest;
use App\Models\Segment;
use Inertia\Inertia;
use Inertia\Response;

class ExtractController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Extract/Index', [
            'segments' => Segment::getAll(),
        ]);
    }

    public function show(Segment $segment, ShowRequest $request): Response
    {
        $data = $request->validated();
        return Inertia::render('Extract/Show', [
            'transactions' => $segment->getFilteredTransactions($data),
            'segment' => $segment,
            'filters' => $request->validated(),
            'initial_balance' => $segment->getBalanceAtDate($data['initial_date']),
            'final_balance' => $segment->getBalanceAtDate($data['final_date']),
        ]);
    }
}
