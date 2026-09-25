<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Task</title>
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
            --field-bg: #FFFFFF;
            --line: #DEDBD1;
            --done: #4B7A5E;
            --done-soft: #E4EEE7;
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
            max-width: 480px;
            margin: 0 auto;
            padding: 72px 28px 110px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--ink-soft);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
        .back svg { width: 12px; height: 12px; }
        .back:hover { color: var(--accent-deep); }

        h1 {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 34px;
            line-height: 1.15;
            letter-spacing: -0.01em;
            margin: 22px 0 40px;
        }

        .field { margin-bottom: 24px; }
        .field:last-of-type { margin-bottom: 0; }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-soft);
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            background: var(--field-bg);
            border: 1.5px solid var(--line);
            border-radius: 6px;
            padding: 12px 14px;
            color: var(--ink);
            font-family: inherit;
            font-size: 14.5px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input[type="text"]::placeholder,
        textarea::placeholder { color: var(--ink-faint); }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--field-bg), 0 0 0 5px rgba(52, 84, 209, 0.16);
        }

        textarea { resize: vertical; min-height: 96px; font-family: inherit; }

        .status-toggle {
            display: flex;
            gap: 8px;
        }
        .status-toggle input { position: absolute; opacity: 0; pointer-events: none; }
        .status-toggle label.opt {
            flex: 1;
            text-align: center;
            padding: 11px 0;
            border-radius: 6px;
            border: 1.5px solid var(--line);
            background: var(--field-bg);
            color: var(--ink-soft);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
            margin: 0;
        }
        .status-toggle input#status_pending:checked + label.opt {
            background: var(--ink);
            border-color: var(--ink);
            color: #FFFFFF;
        }
        .status-toggle input#status_completed:checked + label.opt {
            background: var(--done-soft);
            border-color: var(--done);
            color: var(--done);
        }
        .status-toggle input:focus-visible + label.opt {
            box-shadow: 0 0 0 3px rgba(52, 84, 209, 0.2);
        }

        .actions {
            margin-top: 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .btn-cancel {
            color: var(--ink-soft);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-cancel:hover { color: var(--ink); }

        button[type="submit"] {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: var(--paper);
            border: none;
            font-weight: 600;
            font-size: 14px;
            padding: 13px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        button[type="submit"]:hover { background: var(--accent-deep); }
        button[type="submit"] svg { width: 13px; height: 13px; }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ route('tasks.index') }}" class="back">
            <svg viewBox="0 0 16 16" fill="none"><path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to tasks
        </a>
        <h1>Add something to do</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="field">
                <label for="task_name">Task name</label>
                <input type="text" id="task_name" name="task_name" placeholder="What needs doing?" required>
            </div>

            <div class="field">
                <label for="description">Notes (optional)</label>
                <textarea id="description" name="description" rows="4" placeholder="Add a little context..."></textarea>
            </div>

            <div class="field">
                <label>Status</label>
                <div class="status-toggle">
                    <input type="radio" id="status_pending" name="status" value="Pending" checked>
                    <label class="opt" for="status_pending">Pending</label>
                    <input type="radio" id="status_completed" name="status" value="Completed">
                    <label class="opt" for="status_completed">Completed</label>
                </div>
            </div>

            <div class="field">
                <label for="due_date">Due date</label>
                <input type="date" id="due_date" name="due_date">
            </div>

            <div class="actions">
                <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit">
                    Add to list
                    <svg viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </form>
    </div>
</body>
</html>