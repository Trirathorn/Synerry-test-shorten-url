<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Click;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $code)
    {
        $url = Url::where('short_code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        // record click
        Click::create([
            'url_id' => $url->id,
            'clicked_at' => now(),
            'referer' => (string) $request->headers->get('referer'),
            'user_agent' => (string) $request->userAgent(),
            'ip_hash' => $request->ip() ? hash('sha256', $request->ip()) : null,
            'country' => null,
        ]);

        $url->increment('total_clicks');

        return redirect()->away($url->long_url, 302);
    }
}


