<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\BreadcrumbService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    protected $breadcrumbService;
    /**
     * method constructor .   
     */
    public function __construct(BreadcrumbService $breadcrumbService)
    {
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        $request->session()->regenerate();
 
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redireciona o usuário para a pagina incial de acordo com seu perfil
     *
     * @return View
     * 
     */
    public function homeProfile(): View
    {
        $return  = $this->breadcrumbService->generate('profile.home'); // generate breabcrumb
        if(Auth::user()->profile ==  '0'){
            return view('requisitante.home')->with(['breadcrumbs' =>  $return['data']]);
        }else if(Auth::user()->profile ==  '1'){
            return view('agenteContratacao.home')->with(['breadcrumbs' =>  $return['data']]);
        }
    }
}
