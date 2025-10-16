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
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            box-sizing: border-box;
        }
        * { box-sizing: border-box; }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 16px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 30px; 
            text-align: center;
        }
        .header h1 { 
            margin: 0; 
            font-size: 2.5rem; 
            font-weight: 700; 
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .user-info { 
            margin-top: 15px; 
            font-size: 1.1rem; 
            opacity: 0.9;
        }
        .content { 
            padding: 30px; 
            width: 100%;
            box-sizing: border-box;
        }
        .card { 
            background: #f8fafc; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 25px; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            width: 100%;
            box-sizing: border-box;
        }
        .form-group { 
            margin-bottom: 20px; 
            width: 100%;
            box-sizing: border-box;
        }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #374151; 
        }
        input[type=url], input[type=text] { 
            width: 100%; 
            max-width: 100%;
            padding: 12px 16px; 
            border: 2px solid #e2e8f0; 
            border-radius: 8px; 
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        input[type=url]:focus, input[type=text]:focus { 
            outline: none; 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-primary { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            border: 0; 
            padding: 12px 24px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary { 
            background: #6b7280; 
            color: white; 
            border: 0; 
            padding: 8px 16px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 14px;
        }
        .btn-success { 
            background: #10b981; 
            color: white; 
            border: 0; 
            padding: 6px 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 12px;
        }
        .btn-danger { 
            background: #ef4444; 
            color: white; 
            border: 0; 
            padding: 6px 12px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        th { 
            background: #f8fafc; 
            padding: 15px; 
            text-align: left; 
            font-weight: 600; 
            color: #374151;
            border-bottom: 2px solid #e2e8f0;
        }
        td { 
            padding: 15px; 
            border-bottom: 1px solid #e2e8f0; 
            vertical-align: top;
        }
        tr:hover { background: #f8fafc; }
        .muted { color: #6b7280; font-size: 12px; }
        .badge { 
            background: #f3f4f6; 
            border: 1px solid #e5e7eb; 
            padding: 4px 8px; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: 500;
        }
        .badge-success { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .badge-danger { background: #fee2e2; color: #991b1b; border-color: #fecaca; }
        a { color: #2563eb; text-decoration: none; font-weight: 500; }
        a:hover { text-decoration: underline; }
        .qr-container { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        }
        .qr-code { 
            border: 2px solid #e2e8f0; 
            border-radius: 8px; 
            padding: 8px; 
            background: white;
        }
        .url-info { flex: 1; }
        .actions { 
            display: flex; 
            gap: 8px; 
            flex-wrap: wrap;
        }
        .stats-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px;
        }
        .stats-number { 
            font-size: 2rem; 
            font-weight: 700; 
            margin-bottom: 5px;
        }
        .stats-label { 
            font-size: 0.9rem; 
            opacity: 0.9;
        }
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
        
        // Real-time click count updates
        function updateClickCounts() {
            fetch('/api/click-counts')
                .then(response => response.json())
                .then(data => {
                    data.forEach(url => {
                        const element = document.querySelector(`[data-url-id="${url.id}"] .click-count`);
                        if (element) {
                            const currentCount = parseInt(element.textContent);
                            const newCount = url.total_clicks;
                            if (newCount > currentCount) {
                                element.textContent = newCount;
                                // Add a subtle animation
                                element.style.transform = 'scale(1.1)';
                                element.style.color = '#10b981';
                                setTimeout(() => {
                                    element.style.transform = 'scale(1)';
                                    element.style.color = '#667eea';
                                }, 500);
                            }
                        }
                    });
                })
                .catch(error => console.log('Update failed:', error));
        }
        
        // Update every x miliseconds
        setInterval(updateClickCounts, 2000);
        
        // Update immediately when page loads
        document.addEventListener('DOMContentLoaded', updateClickCounts);
    </script>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔗 URL Shortener</h1>
            <div class="user-info">
                Welcome back, {{ Auth::user()->display_name }}!
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 16px;">
                    @csrf
                    <button type="submit" class="btn-secondary">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="content">

            <div class="card">
                <h2 style="margin-top: 0; color: #374151; font-size: 1.5rem;">Create New Short URL</h2>
                <form method="POST" action="{{ route('urls.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>🌐 Long URL</label>
                        <input type="url" name="long_url" placeholder="https://example.com" value="{{ old('long_url') }}" required>
                    </div>
                    <div class="form-group">
                        <label>📝 Title (optional)</label>
                        <input type="text" name="title" placeholder="My awesome link" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label>🔗 Custom code (optional)</label>
                        <input type="text" name="custom_code" placeholder="e.g. mycode" pattern="[A-Za-z0-9]{4,16}" value="{{ old('custom_code') }}">
                    </div>
                    <button type="submit" class="btn-primary">✨ Create Short URL</button>
                    
                    @if (session('created'))
                        <div style="margin-top: 15px; padding: 12px; background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 8px; color: #166534;">
                            ✅ Created: <a href="{{ session('created') }}" target="_blank" style="font-weight: 600;">{{ session('created') }}</a>
                        </div>
                    @endif
                    
                    @if (session('deleted'))
                        <div style="margin-top: 15px; padding: 12px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; color: #991b1b;">
                            🗑️ {{ session('deleted') }}
                        </div>
                    @endif
                    
                    @error('long_url')<div class="muted" style="color: #ef4444; margin-top: 8px;">{{ $message }}</div>@enderror
                    @error('title')<div class="muted" style="color: #ef4444; margin-top: 8px;">{{ $message }}</div>@enderror
                    @error('custom_code')<div class="muted" style="color: #ef4444; margin-top: 8px;">{{ $message }}</div>@enderror
                </form>
            </div>

            <div class="card">
                <h2 style="margin-top: 0; color: #374151; font-size: 1.5rem;">📊 Your URLs</h2>
                @if($urls->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>🔗 Short URL & QR</th>
                                <th>📝 Title</th>
                                <th>🌐 Original URL</th>
                                <th>📈 Clicks</th>
                                <th>⚙️ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($urls as $u)
                                <tr>
                                    <td>
                                        <div class="qr-container">
                                            <div class="url-info">
                                                <a href="/{{ $u->short_code }}" target="_blank" style="font-weight: 600; font-size: 1.1rem;">/{{ $u->short_code }}</a>
                                                <div style="margin-top: 8px;">
                                                    <button type="button" class="btn-success" onclick="copyToClipboard('{{ url('/'.$u->short_code) }}')">📋 Copy</button>
                                                </div>
                                            </div>
                                            <div class="qr-code">
                                                <img src="{{ route('urls.qr', $u) }}" alt="QR Code" width="64" height="64">
                                            </div>
                                        </div>
                                    </td>
                                    <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight: 500;">
                                        {{ $u->title ?: 'No title' }}
                                    </td>
                                    <td style="max-width:400px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        <a href="{{ $u->long_url }}" target="_blank" style="color: #6b7280;">{{ $u->long_url }}</a>
                                    </td>
                                    <td style="text-align: center; font-weight: 600; font-size: 1.1rem; color: #667eea;" data-url-id="{{ $u->id }}">
                                        <span class="click-count">{{ $u->total_clicks }}</span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <form method="POST" action="{{ route('urls.toggle', $u) }}" style="display:inline">
                                                @csrf
                                                <button type="submit" class="{{ $u->is_active ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $u->is_active ? '✅ Active' : '❌ Inactive' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('urls.stats', $u) }}" class="btn-primary" style="text-decoration: none; display: inline-block;">📊 Stats</a>
                                            <form method="POST" action="{{ route('urls.destroy', $u) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this URL? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger">🗑️ Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top: 20px; text-align: center;">{{ $urls->links() }}</div>
                @else
                    <div style="text-align: center; padding: 40px; color: #6b7280;">
                        <div style="font-size: 3rem; margin-bottom: 16px;">🔗</div>
                        <h3 style="color: #374151; margin-bottom: 8px;">No URLs yet</h3>
                        <p>Create your first short URL above to get started!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>


