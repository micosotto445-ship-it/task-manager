<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,500;0,600;0,700;1,500&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #F6F4EE;
            --surface: #FFFFFF;
            --ink: #1C1F2B;
            --ink-soft: #5B5F6E;
            --ink-faint: #9A9DA8;
            --accent: #3454D1;
            --accent-deep: #2740A8;
            --accent-soft: #E7EBFB;
            --done: #4B7A5E;
            --done-soft: #E4EEE7;
            --line: #DEDBD1;
            --danger: #B84A3E;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: 'IBM Plex Sans', -apple-system, sans-serif;
            font-size: 15px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        .wrap {
            max-width: 760px;
            margin: 0 auto;
            padding: 72px 28px 110px;
        }

        .top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 40px;
            line-height: 1.1;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: var(--paper);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 20px;
            border-radius: 6px;
            transition: background 0.15s ease;
            white-space: nowrap;
        }
        .btn-new:hover { background: var(--accent-deep); }
        .btn-new svg { width: 14px; height: 14px; }

        .subline {
            color: var(--ink-soft);
            font-size: 14px;
            margin: 6px 0 44px;
        }

        .list {
            border-top: 1.5px solid var(--ink);
        }

        .row {
            display: grid;
            grid-template-columns: 28px 1fr auto auto;
            align-items: start;
            gap: 18px;
            padding: 20px 2px;
            border-bottom: 1px solid var(--line);
        }

        .status-form { margin: 2px 0 0; }

        .status-box {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            border: 1.6px solid var(--ink-faint);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            transition: border-color 0.15s ease, background 0.15s ease;
        }
        .status-box svg { width: 12px; height: 12px; opacity: 0; transition: opacity 0.15s ease; }
        .status-box:hover { border-color: var(--accent); }
        .status-box.is-done {
            background: var(--done);
            border-color: var(--done);
        }
        .status-box.is-done svg { opacity: 1; }

        .row-main { min-width: 0; }

        .task-name {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 18px;
            color: var(--ink);
            display: block;
        }
        .row.is-complete .task-name {
            color: var(--ink-faint);
            text-decoration: line-through;
            text-decoration-color: var(--ink-faint);
        }

        .row-desc {
            margin: 4px 0 0;
            color: var(--ink-soft);
            font-size: 13.5px;
            max-width: 440px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .col-status {
            display: flex;
            align-items: center;
            gap: 7px;
            padding-top: 2px;
            white-space: nowrap;
        }
        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent);
        }
        .row.is-complete .status-dot { background: var(--done); }
        .status-text {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .col-due {
            padding-top: 2px;
            font-size: 13px;
            color: var(--ink-faint);
            white-space: nowrap;
            text-align: right;
        }

        .row-actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 16px;
            margin-top: 12px;
            padding-left: 46px;
        }
        .row-actions form { margin: 0; }

        .text-action {
            border: none;
            background: none;
            padding: 0;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-soft);
            text-decoration: none;
            cursor: pointer;
            border-bottom: 1px solid transparent;
            transition: color 0.15s ease, border-color 0.15s ease;
        }
        .text-action:hover { color: var(--accent-deep); border-color: var(--accent-deep); }
        .text-action.danger:hover { color: var(--danger); border-color: var(--danger); }

        .empty {
            padding: 90px 10px 40px;
            text-align: center;
        }
        .empty-title {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 22px;
            margin: 0 0 8px;
        }
        .empty-sub {
            color: var(--ink-soft);
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 560px) {
            .row { grid-template-columns: 24px 1fr; }
            .col-status, .col-due { grid-column: 2; padding-top: 6px; }
            .col-due { text-align: left; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top">
            <h1>Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="btn-new">
                <svg viewBox="0 0 16 16" fill="none"><path d="M8 2.5v11M2.5 8h11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                New task
            </a>
        </div>

        @php
            $total = isset($tasks) ? count($tasks) : 0;
        @endphp
        <p class="subline">{{ $total }} {{ Str::plural('task', $total) }} on the list</p>

        <div class="list">
            @forelse($tasks as $task)
                <div class="row {{ $task->status == 'Completed' ? 'is-complete' : '' }}">
                    <form class="status-form" action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="status-box {{ $task->status == 'Completed' ? 'is-done' : '' }}" aria-label="Toggle status">
                            <svg viewBox="0 0 16 16" fill="none"><path d="M3.5 8.5l3 3 6-6.5" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>

                    <div class="row-main">
                        <span class="task-name">{{ $task->task_name }}</span>
                        @if($task->description)
                            <p class="row-desc">{{ $task->description }}</p>
                        @endif
                    </div>

                    <div class="col-status">
                        <span class="status-dot"></span>
                        <span class="status-text">{{ $task->status }}</span>
                    </div>

                    <div class="col-due">{{ $task->due_date }}</div>

                    <div class="row-actions">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-action">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-action danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty">
                    <p class="empty-title">Nothing on the list yet</p>
                    <p class="empty-sub">Add your first task to start tracking it here.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>