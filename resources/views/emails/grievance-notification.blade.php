<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grievance Notification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #8B0000 0%, #DC2626 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-top: none;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin: 10px 0;
        }
        .badge-new {
            background: #FEF3C7;
            color: #92400E;
        }
        .badge-pending {
            background: #FED7AA;
            color: #9A3412;
        }
        .badge-in-progress {
            background: #DBEAFE;
            color: #1E40AF;
        }
        .badge-resolved {
            background: #D1FAE5;
            color: #065F46;
        }
        .info-section {
            background: #F9FAFB;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #E5E7EB;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            width: 140px;
            color: #6B7280;
        }
        .info-value {
            flex: 1;
            color: #111827;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6B7280;
            font-size: 13px;
        }
        .btn {
            display: inline-block;
            background: #8B0000;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .description-box {
            background: #F9FAFB;
            border-left: 4px solid #8B0000;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            @if($type === 'new')
                🔔 New Grievance Notification
            @else
                ✉️ Grievance Status Update
            @endif
        </h1>
    </div>

    <div class="content">
        @if($type === 'new')
            <p>Dear <strong>{{ $grievance->name_snapshot }}</strong>,</p>
            <p>A grievance case has been filed concerning you by the Office of Student Affairs and Services (OSAS).</p>
        @else
            <p>Dear <strong>{{ $grievance->name_snapshot }}</strong>,</p>
            <p>The status of your grievance case has been updated.</p>

            @if($oldStatus)
            <div style="margin: 15px 0;">
                <span class="badge badge-{{ $oldStatus }}">{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</span>
                <span style="margin: 0 10px;">→</span>
                <span class="badge badge-{{ $grievance->status }}">{{ ucfirst(str_replace('_', ' ', $grievance->status)) }}</span>
            </div>
            @endif
        @endif

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Case ID:</span>
                <span class="info-value"><strong>{{ $grievance->case_id }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Type:</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $grievance->grievance)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    <span class="badge badge-{{ $grievance->status }}">
                        {{ ucfirst(str_replace('_', ' ', $grievance->status)) }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Date Filed:</span>
                <span class="info-value">{{ $grievance->created_at->format('F d, Y') }}</span>
            </div>
            @if($grievance->filed_by_name_snapshot)
            <div class="info-row">
                <span class="info-label">Filed By:</span>
                <span class="info-value">{{ $grievance->filed_by_name_snapshot }}</span>
            </div>
            @endif
        </div>

        @if($grievance->description)
        <div class="description-box">
            <strong>Description:</strong>
            <p style="margin: 10px 0 0 0;">{{ $grievance->description }}</p>
        </div>
        @endif

        @if($grievance->remarks)
        <div class="description-box">
            <strong>Remarks:</strong>
            <p style="margin: 10px 0 0 0;">{{ $grievance->remarks }}</p>
        </div>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ config('app.url') }}/student/grievances" class="btn">
                View Grievance Details
            </a>
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #6B7280;">
            If you have any questions or concerns regarding this case, please contact the Office of Student Affairs and Services.
        </p>
    </div>

    <div class="footer">
        <p><strong>University of Southeastern Philippines</strong></p>
        <p>Office of Student Affairs and Services<br>
        Iñigo St., Bo. Obrero, Davao City</p>
        <p style="margin-top: 15px;">
            This is an automated message. Please do not reply to this email.
        </p>
    </div>
</body>
</html>
