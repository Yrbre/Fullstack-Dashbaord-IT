<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>No Activity Detected</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 50%, #f8fafc 100%);
            min-height: 100vh;
            padding: 24px;
        }

        .email-shell {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
            border: 1px solid rgba(59, 130, 246, 0.08);
        }

        .header {
            padding: 36px 40px;
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
            color: #ffffff;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 42%);
        }

        .header h1,
        .header p {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.84);
            font-size: 15px;
        }

        .content {
            padding: 40px;
            background: #ffffff;
        }

        .card {
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            border: 1px solid #dbeafe;
            border-radius: 20px;
            padding: 28px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1d4ed8;
            margin-bottom: 18px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .detail-item {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }

        .description-box {
            margin-top: 18px;
            background: #ffffff;
            border-radius: 16px;
            padding: 18px 20px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        }

        .description-text {
            font-size: 15px;
            color: #334155;
            white-space: pre-line;
            word-break: break-word;
        }

        .footer {
            padding: 24px 40px 36px;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .footer-note {
            font-size: 14px;
            color: #475569;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 13px;
            color: #94a3b8;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 12px;
            }

            .header,
            .content,
            .footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    @php
        $userName = optional($item->user)->name ?? '-';
        $lastActivityAt = !empty($item->start_time) ? \Carbon\Carbon::parse($item->start_time) : null;
        $inactiveMinutes = $item->last_notified_minute ?? '-';
    @endphp

    <div class="email-shell">
        <div class="header">
            <h1>No Activity Detected</h1>
            <p>Informasi notifikasi aktivitas terbaru dari sistem IT Department.</p>
        </div>

        <div class="content">
            <div class="card">
                <div class="section-title">Activity Alert</div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">User Name</div>
                        <div class="detail-value">{{ $userName }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Inactive Minutes</div>
                        <div class="detail-value">{{ $inactiveMinutes }} minutes</div>
                    </div>
                </div>

                <div class="description-box">
                    <div class="detail-label">Last Activity</div>
                    <div class="description-text">
                        {{ $lastActivityAt ? $lastActivityAt->format('d F Y, H:i') : '-' }}
                    </div>
                </div>

                <div class="description-box">
                    <div class="detail-label">Reminder</div>
                    <div class="description-text">
                        We have noticed that there has been no activity detected for the past {{ $inactiveMinutes }}
                        minutes.
                        Please ensure you are actively monitoring your tasks and activities to maintain productivity.
                        If you need assistance, please contact the support team.
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-note">
                Please review this record if any correction is needed.
            </div>
            <div class="company-info">
                © {{ date('Y') }} PT. TIFICO FIBER INDONESIA, Tbk. All rights reserved.<br>
                IT Department
            </div>
        </div>
    </div>
</body>

</html>
