<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 24px; }
        .container { max-width: 900px; margin: 0 auto; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        input[type=url], input[type=text] { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; }
        button { background: #ef4444; color: white; border: 0; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .muted { color: #6b7280; font-size: 12px; }
        .badge { background: #f3f4f6; border: 1px solid #e5e7eb; padding: 2px 8px; border-radius: 9999px; font-size: 12px; }
        a { color: #2563eb; text-decoration: none; }
    </style>
    @if (session('created'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            navigator.clipboard?.writeText(@json(session('created'))).catch(() => {});
        });
    </script>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function copyToClipboard(text) { navigator.clipboard.writeText(text); alert('Copied'); }
    </script>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>

        <div class="card">
            <form method="POST" action="{{ route('urls.store') }}">
                @csrf
                <label>Long URL</label>
                <input type="url" name="long_url" placeholder="https://example.com" required>
                <div style="height:8px"></div>
                <label>Title (optional)</label>
                <input type="text" name="title" placeholder="My link">
                <div style="height:8px"></div>
                <label>Custom code (optional)</label>
                <input type="text" name="custom_code" placeholder="e.g. mycode" pattern="[A-Za-z0-9]{4,16}">
                <div style="height:8px"></div>
                <label>Expire at (optional)</label>
                <input type="datetime-local" name="expires_at">
                <div style="height:12px"></div>
                <button type="submit">Create Short URL</button>
                @if (session('created'))
                    <span class="badge">created: <a href="{{ session('created') }}" target="_blank">{{ session('created') }}</a></span>
                @endif
                @error('long_url')<div class="muted">{{ $message }}</div>@enderror
            </form>
        </div>

        <div class="card">
            <h3>Your URLs</h3>
            <table>
                <thead>
                    <tr>
                        <th>Short / QR</th>
                        <th>Title</th>
                        <th>Long</th>
                        <th>Clicks</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($urls as $u)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div>
                                        <a href="/{{ $u->short_code }}" target="_blank">/{{ $u->short_code }}</a>
                                        <div class="muted" style="margin-top:4px;">
                                            <button type="button" class="badge" onclick="copyToClipboard('{{ url('/'.$u->short_code) }}')">Copy</button>
                                        </div>
                                    </div>
                                    <div>
                                        <img src="{{ route('urls.qr', $u) }}" alt="qr" width="64" height="64" style="display:block;">
                                    </div>
                                </div>
                            </td>
                            <td style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $u->title }}</td>
                            <td style="max-width:420px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                <a href="{{ $u->long_url }}" target="_blank">{{ $u->long_url }}</a>
                            </td>
                            <td>{{ $u->total_clicks }}</td>
                            <td>
                                <form method="POST" action="{{ route('urls.toggle', $u) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="badge" style="background: {{ $u->is_active ? '#dcfce7' : '#fee2e2' }}; border:1px solid #e5e7eb;">{{ $u->is_active ? 'Active' : 'Inactive' }}</button>
                                </form>
                                <a href="{{ route('urls.stats', $u) }}" class="badge">Stats</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:10px;">{{ $urls->links() }}</div>
        </div>
    </div>
</body>
</html>


