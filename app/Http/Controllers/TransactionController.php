<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Transaction\CreateNewTransaction;
use App\Actions\Transaction\PaginateTransactionsRecords;
use App\Actions\Transaction\UpdateTransaction;
use App\Enums\TransactionPaginateType;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Models\Segment;
use App\Models\Transaction;
use App\Support\Facades\FlashMessages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function index(Request $request): Response
    {
        if ($transactions = PaginateTransactionsRecords::run($request, TransactionPaginateType::ALL)) {
            return Inertia::render('Transaction/Index', [
                'transactions' => $transactions,
                'pending_count' => Transaction::countPending(),
                'segments' => Segment::getAll(true),
            ]);
        } else {
            return redirect()->route('transactions.index',['items' => $request->query('items')]);
        }
    }

    public function pending(Request $request): Response
    {
        if ($transactions = PaginateTransactionsRecords::run($request, TransactionPaginateType::PENDING)) {
            return Inertia::render('Transaction/Pending', [
                'transactions' => $transactions,
                'segments' => Segment::getAll(true),
            ]);
        } else {
            return redirect()->route('transactions.pending',['items' => $request->query('items')]);
        }
    }

    public function grouped(Request $request): Response{
        if ($transactions = PaginateTransactionsRecords::run($request, TransactionPaginateType::GROUPED)) {
            return Inertia::render('Transaction/Grouped', [
                'groups' => $transactions,
                'pending_count' => Transaction::countPending(),
                'segments' => Segment::getAll(true),
            ]);
        } else {
            return redirect()->route('transactions.grouped',['items' => $request->query('items')]);
        }
    }

    public function show(string $group_id): Response
    {
        return Inertia::render('Transaction/Show', Transaction::getAllByGroupId($group_id));
    }

    public function create(): Response
    {
        return Inertia::render('Transaction/Create', [
            'segments' => Segment::getAll(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        CreateNewTransaction::create($request->validated());
        FlashMessages::success('Transação criada com sucesso');
        if ($request->validated('pending'))
            FlashMessages::warning('Essa transação deverá ser atualizado manualmente para ser contabilizado no sistema');
        return back();
    }

    public function edit(Transaction $transaction): Response
    {
        return Inertia::render('Transaction/Edit', [
            'transaction' => $transaction,
        ]);
    }

    public function update(UpdateRequest $request, Transaction $transaction): RedirectResponse
    {
        UpdateTransaction::update($transaction, $request->validated());
        FlashMessages::success('Transação editada com sucesso');
        if ($request->validated('pending')) {
            return back();
        } else {
            FlashMessages::warning('Essa transação agora será contabilizadas no sistema');
            return redirect()->route('transactions.pending');
        }
    }

    public function release(Transaction $transaction): RedirectResponse
    {
        $transaction->update([
            'pending' => false,
            'created_at' => now(),
        ]);
        FlashMessages::success('Transação lançada com sucesso');
        return back();
    }
}
