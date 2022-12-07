<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Segment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard/Index');
    }

    public function balances(): array
    {
        return Segment::getBalances();
    }

    public function pending(): Collection
    {
        return Transaction::getPending();
    }
}
