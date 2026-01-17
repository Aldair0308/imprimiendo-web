<?php

namespace App\Http\Controllers;

use App\Models\QRSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class QRController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('qr_sessions')) {
            $duration = (int) (Config::get('imprimeindo.qr_session_duration', env('QR_SESSION_DURATION', 1800)));
            $session = (object) [
                'token' => hash('sha256', Str::uuid()->toString() . Str::random(16)),
                'expires_at' => Carbon::now()->addSeconds($duration),
            ];
            return view('home', ['session' => $session]);
        }
        $session = $this->createOrRefreshSession($request->user());
        return view('home', ['session' => $session]);
    }

    public function scan($token)
    {
        $session = QRSession::where('token', $token)->first();

        if (!$session || !$session->active || now()->greaterThan($session->expires_at)) {
            return redirect()->route('home')->with('error', 'El código QR ha expirado o no es válido.');
        }

        return view('scan', ['session' => $session]);
    }

    public function refresh(Request $request)
    {
        if (!Schema::hasTable('qr_sessions')) {
            $duration = (int) (Config::get('imprimeindo.qr_session_duration', env('QR_SESSION_DURATION', 1800)));
            $token = hash('sha256', Str::uuid()->toString() . Str::random(16));
            return response()->json([
                'token' => $token,
                'expires_at' => Carbon::now()->addSeconds($duration)->toIso8601String(),
            ]);
        }
        $session = $this->createOrRefreshSession($request->user(), true);
        return response()->json([
            'token' => $session->token,
            'expires_at' => $session->expires_at->toIso8601String(),
        ]);
    }

    public function validateToken(Request $request)
    {
        if (!Schema::hasTable('qr_sessions')) {
            return response()->json(['valid' => false], 400);
        }
        $token = $request->input('token');
        $session = QRSession::where('token', $token)->first();
        if (!$session || !$session->active || now()->greaterThan($session->expires_at)) {
            return response()->json(['valid' => false], 400);
        }
        return response()->json(['valid' => true]);
    }

    protected function createOrRefreshSession(?\App\Models\User $user, bool $forceRefresh = false): QRSession
    {
        $duration = (int) (Config::get('imprimeindo.qr_session_duration', env('QR_SESSION_DURATION', 1800)));
        $refreshInterval = (int) (Config::get('imprimeindo.qr_refresh_interval', env('QR_REFRESH_INTERVAL', 30)));

        $session = QRSession::where('user_id', optional($user)->id)->latest()->first();

        $shouldRefresh = $forceRefresh
            || !$session
            || $session->refreshed_at === null
            || $session->refreshed_at->diffInSeconds(now()) >= $refreshInterval;

        if (!$session || now()->greaterThan(optional($session)->expires_at) || $shouldRefresh) {
            $token = hash('sha256', Str::uuid()->toString() . Str::random(16));
            $session = QRSession::updateOrCreate(
                ['id' => optional($session)->id],
                [
                    'token' => $token,
                    'expires_at' => Carbon::now()->addSeconds($duration),
                    'refreshed_at' => now(),
                    'user_id' => optional($user)->id,
                    'active' => true,
                ]
            );
        }

        return $session;
    }
}
