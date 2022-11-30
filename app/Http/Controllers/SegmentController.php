<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Segment\StoreUpdateRequest;
use App\Models\Segment;
use App\Support\Facades\FlashMessages;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SegmentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Segment/Index', [
            'segments' => Segment::getAll(true),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Segment/Create');
    }

    public function store(StoreUpdateRequest $request): RedirectResponse
    {
        $id = Segment::createAndReturnId($request->validated());
        FlashMessages::success('Segmento criado com sucesso');
        return redirect()
                    ->route('segments.edit', [
                        'segment' => $id
                    ]);
    }

    public function edit(Segment $segment): Response
    {
        return Inertia::render('Segment/Edit', [
            'segment' => $segment,
        ]);
    }

    public function update(StoreUpdateRequest $request, Segment $segment): RedirectResponse
    {
        $segment->update(
            $request->validated()
        );
        FlashMessages::success('Segmento editado com sucesso');
        return back();
    }

    public function destroy(Segment $segment): RedirectResponse
    {
        FlashMessages::success(
            'Segmento '.($segment->deleteOrRestore() === 'deleted' ? 'desativado' : 'ativado'). ' com sucesso'
        );
        return back();
    }
}
