<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL as UrlHelper;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::where('user_id', Auth::id())->orderByDesc('id')->paginate(10);
        return view('home', compact('urls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'long_url' => ['required', 'url', 'max:2000'],
            'title' => ['nullable', 'string', 'max:255', Rule::unique('urls', 'title')],
            'custom_code' => ['nullable', 'alpha_num', 'min:4', 'max:16', Rule::unique('urls', 'short_code')],
        ]);

        $shortCode = $validated['custom_code'] ?? $this->generateUniqueCode();

        $url = Url::create([
            'user_id' => Auth::id(),
            'long_url' => $validated['long_url'],
            'short_code' => $shortCode,
            'title' => $validated['title'] ?? null,
        ]);

        $shortUrl = UrlHelper::to('/' . $url->short_code);

        return redirect()->route('home')->with('created', $shortUrl);
    }

    public function toggle(Url $url)
    {
        if (Auth::id() !== $url->user_id) {
            abort(403);
        }
        $url->is_active = ! $url->is_active;
        $url->save();
        return redirect()->route('home');
    }

    public function qr(Url $url)
    {
        $shortUrl = UrlHelper::to('/' . $url->short_code);
        // Use SVG output to avoid Imagick/GD dependencies
        $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(256)->errorCorrection('M')->generate($shortUrl);
        return response($svg)->header('Content-Type', 'image/svg+xml');
    }

    public function destroy(Url $url)
    {
        if (Auth::id() !== $url->user_id) {
            abort(403);
        }
        
        $url->delete();
        
        return redirect()->route('home')->with('deleted', 'URL deleted successfully.');
    }

    public function stats(Url $url)
    {
        if (Auth::id() !== $url->user_id) {
            abort(403);
        }
        $url->loadCount('clicks');
        $recentClicks = $url->clicks()->orderByDesc('clicked_at')->limit(20)->get();
        return view('stats', compact('url', 'recentClicks'));
    }

    public function getClickCounts()
    {
        $urls = Url::where('user_id', Auth::id())
            ->select('id', 'short_code', 'total_clicks')
            ->get();
        
        return response()->json($urls);
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (Url::where('short_code', $code)->exists());
        return $code;
    }
}


