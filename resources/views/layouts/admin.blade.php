<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Shkolla</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; min-height: 100vh; background: #1e1b4b; display: flex; flex-direction: column; flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; }
        .sidebar-brand { padding: 24px 20px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-brand h1 { color: #fff; font-size: 18px; font-weight: 700; }
        .sidebar-brand p  { color: rgba(255,255,255,.4); font-size: 11px; margin-top: 2px; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.3); text-transform: uppercase; letter-spacing: 1px; padding: 12px 8px 6px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; color: rgba(255,255,255,.6); text-decoration: none; font-size: 14px; font-weight: 500; margin-bottom: 2px; transition: all .15s; }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-link.active { background: #4f46e5; color: #fff; }
        .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,.08); }
        .admin-name { color: rgba(255,255,255,.7); font-size: 13px; font-weight: 500; }
        .logout-btn { display: inline-flex; align-items: center; gap: 6px; margin-top: 8px; color: rgba(255,255,255,.4); font-size: 12px; text-decoration: none; background: none; border: none; cursor: pointer; padding: 0; font-family: inherit; }
        .logout-btn:hover { color: #f87171; }

        /* ── Main ── */
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .badge-admin { background: #eef2ff; color: #4f46e5; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .page-content { padding: 28px; flex: 1; }

        /* ── Cards ── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
        .stat-card .label { font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .stat-card .value { font-size: 32px; font-weight: 800; margin: 6px 0 4px; }
        .stat-card .sub   { font-size: 12px; color: #94a3b8; }
        .card { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,.06); margin-bottom: 20px; }
        .card-title { font-size: 15px; font-weight: 700; margin-bottom: 16px; }

        /* ── Table ── */
        .table-wrap { border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; background: #fff; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; }
        th { text-align: left; font-size: 10.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .8px; padding: 13px 20px; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
        td { padding: 14px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background .1s; }
        tbody tr:hover td { background: #f8fafc; }

        /* ── User cell ── */
        .user-cell { display: flex; align-items: center; gap: 12px; }
        .u-avatar { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .u-name { font-weight: 600; color: #1e293b; font-size: 14px; }
        .u-email { font-size: 12px; color: #94a3b8; margin-top: 1px; }

        /* ── Table empty state ── */
        .table-empty { text-align: center; padding: 56px 20px; color: #94a3b8; }
        .table-empty svg { width: 40px; height: 40px; margin: 0 auto 12px; display: block; stroke: #cbd5e1; }
        .table-empty p { font-size: 14px; }

        /* ── Action button ── */
        .btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid #fee2e2; background: #fff5f5; color: #ef4444; cursor: pointer; transition: all .15s; font-family: inherit; }
        .btn-icon:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: opacity .15s; font-family: inherit; }
        .btn:hover { opacity: .88; }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-danger  { background: #ef4444; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── Alerts ── */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* ── Role badge ── */
        .role-badge { display: inline-block; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .role-0 { background: #eef2ff; color: #4f46e5; }
        .role-1 { background: #fef9c3; color: #854d0e; }
        .role-2 { background: #f0fdf4; color: #166534; }

        /* ── Modal overlay ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 20px; width: 100%; max-width: 500px; padding: 32px; position: relative; max-height: 90vh; overflow-y: auto; }
        .modal-close { position: absolute; top: 16px; right: 18px; background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1; }
        .modal-close:hover { color: #1e293b; }
        .modal h2 { font-size: 18px; font-weight: 700; margin-bottom: 6px; }
        .modal-sub { color: #94a3b8; font-size: 13px; margin-bottom: 24px; }

        /* ── Role picker ── */
        .role-picker { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 4px; }
        .role-card { border: 2px solid #e2e8f0; border-radius: 14px; padding: 20px 12px; text-align: center; cursor: pointer; transition: all .15s; }
        .role-card:hover { border-color: #4f46e5; background: #f5f3ff; }
        .role-card.selected { border-color: #4f46e5; background: #eef2ff; }
        .role-card svg { width: 32px; height: 32px; margin-bottom: 8px; }
        .role-card .rc-label { font-size: 14px; font-weight: 700; color: #1e293b; }
        .role-card .rc-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* ── Form ── */
        .form-section { display: none; }
        .form-section.visible { display: block; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-control { width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 14px; font-family: inherit; color: #1e293b; background: #f8fafc; outline: none; }
        .form-control:focus { border-color: #4f46e5; background: #fff; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <h1>Shkolla</h1>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <div class="nav-section">Management</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Users
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-name">{{ auth()->user()->name }}</div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
        <div><span class="badge-admin">Admin</span></div>
    </header>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

@stack('modals')
</body>
</html>
