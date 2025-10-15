<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats - {{ $url->short_code }}</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 24px; }
        .container { max-width: 900px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
    </style>
</head>
<body>
<div class="container">
    <h2>Stats for /{{ $url->short_code }}</h2>
    <p>Total clicks: {{ $url->clicks_count }}</p>

    <h3>Recent clicks</h3>
    <table>
        <thead>
            <tr>
                <th>When</th>
                <th>Referer</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($recentClicks as $c)
            <tr>
                <td>{{ $c->clicked_at }}</td>
                <td>{{ $c->referer }}</td>
                <td style="max-width:600px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $c->user_agent }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p><a href="{{ url('/') }}">← Back</a></p>
</div>
</body>
</html>


