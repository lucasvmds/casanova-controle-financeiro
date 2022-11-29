<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Session\CredentialsAreValid;
use App\Actions\Session\LogoutUser;
use App\Actions\Session\UpdateUser;
use App\Http\Requests\Session\StoreRequest;
use App\Http\Requests\Session\UpdateRequest;
use App\Support\Facades\FlashMessages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        return (Auth::check()) ?
            redirect()->route('dashboard.index') :
            Inertia::render('Session/Index');
    }

    public function store(StoreRequest $request)
    {
        if (CredentialsAreValid::run($request->validated())) {
            return redirect()->route('dashboard.index');
        }else {
            FlashMessages::error('As credenciais informadas são inválidas');
            return back();
        }
    }

    public function edit(): Response
    {
        return Inertia::render('Session/Edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        UpdateUser::run($request->validated());
        FlashMessages::success('Dados alterados com sucesso');
        return back();
    }

    public function destroy(): RedirectResponse
    {
        LogoutUser::run();
        return redirect()->route('login');
    }
}
