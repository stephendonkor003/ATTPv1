<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to Your Information Request</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 40px 20px;">
    <div style="max-width: 650px; margin: 0 auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background-color: #ffffff;">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); padding: 30px; text-align: center; color: white;">
            <h2 style="margin: 0; font-size: 24px;">Response to Your Request</h2>
            <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.95;">Africa Think Tank Platform</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 40px 30px; color: #333;">
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Dear <strong>{{ $request->requester->name }}</strong>,
            </p>

            <p style="font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
                We have reviewed your information request and are providing the following response:
            </p>

            <!-- Request Details Box -->
            <div style="margin: 25px 0; padding: 20px; background-color: #f8f9fa; border-left: 4px solid #0891b2; border-radius: 4px;">
                <h4 style="margin-top: 0; color: #0891b2; font-size: 16px;">Your Request</h4>
                <p style="margin: 10px 0;"><strong>Subject:</strong> {{ $request->subject }}</p>
                <p style="margin: 10px 0;"><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</p>
                <p style="margin: 10px 0;"><strong>Submitted:</strong> {{ $request->created_at->format('d M Y H:i') }}</p>
                <p style="margin: 10px 0;">
                    <strong>Status:</strong>
                    <span style="display: inline-block; padding: 4px 10px; border-radius: 4px; background-color: {{ $request->getStatusBadgeClass() }}; color: white; font-size: 13px;">
                        {{ ucfirst($request->status) }}
                    </span>
                </p>
            </div>

            <!-- Response Box -->
            <div style="margin: 25px 0; padding: 20px; background-color: #e0f7fa; border-left: 4px solid #00796b; border-radius: 4px;">
                <h4 style="margin-top: 0; color: #00796b; font-size: 16px;">Our Response</h4>
                <p style="margin: 0; line-height: 1.8; white-space: pre-line;">{{ $request->response }}</p>
            </div>

            @if($request->responder)
            <p style="margin: 20px 0; font-size: 14px; color: #666;">
                <em>Response provided by {{ $request->responder->name }} on {{ $request->responded_at->format('d M Y H:i') }}</em>
            </p>
            @endif

            <!-- Action Button -->
            <div style="text-align: center; margin: 35px 0;">
                <a href="{{ route('partner.requests.show', $request->id) }}"
                   style="display: inline-block; padding: 12px 30px; background-color: #0891b2; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    View Request Details
                </a>
            </div>

            <p style="margin-top: 30px; font-size: 15px; line-height: 1.6;">
                If you have any further questions or need additional information, please don't hesitate to submit another request through the partner portal.
            </p>

            <p style="margin-top: 30px; line-height: 1.6;">
                <strong>Best regards,</strong><br>
                Africa Think Tank Platform Team<br>
                <span style="color: #666; font-size: 14px;">African Union Commission</span>
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #0891b2; color: white; text-align: center; padding: 20px; font-size: 13px;">
            Africa Think Tank Platform — African Union Commission
        </div>
    </div>
</body>
</html>
