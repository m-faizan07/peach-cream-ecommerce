<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry</title>
</head>
<body style="margin:0; padding:0; background:#f6f7fb; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f6f7fb; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:680px; background:#ffffff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(120deg,#f7b38a,#f28c7a); padding:22px 26px;">
                            <div style="font-size:12px; letter-spacing:1px; text-transform:uppercase; color:#fff9f6; font-weight:700;">
                                Peach Cream
                            </div>
                            <h1 style="margin:8px 0 0; font-size:22px; line-height:1.3; color:#ffffff;">
                                New Contact Inquiry Received
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 26px 10px;">
                            <p style="margin:0 0 16px; font-size:14px; color:#4b5563;">
                                A visitor submitted the contact form. Details are below:
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 26px 18px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse:separate; border-spacing:0 10px;">
                                <tr>
                                    <td style="width:120px; font-size:13px; color:#6b7280; font-weight:700;">Name</td>
                                    <td style="font-size:14px; color:#111827; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px 12px;">
                                        {{ $name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:120px; font-size:13px; color:#6b7280; font-weight:700;">Email</td>
                                    <td style="font-size:14px; color:#111827; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px 12px;">
                                        <a href="mailto:{{ $email }}" style="color:#2563eb; text-decoration:none;">{{ $email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:120px; font-size:13px; color:#6b7280; font-weight:700;">Phone</td>
                                    <td style="font-size:14px; color:#111827; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px 12px;">
                                        {{ $phone }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 26px 24px;">
                            <div style="font-size:13px; color:#6b7280; font-weight:700; margin-bottom:8px;">Message</div>
                            <div style="font-size:14px; line-height:1.7; color:#111827; background:#fff7f3; border:1px solid #ffd4c2; border-left:4px solid #f28c7a; border-radius:8px; padding:14px 14px;">
                                {!! nl2br(e($messageText)) !!}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="border-top:1px solid #e5e7eb; padding:14px 26px 18px; font-size:12px; color:#9ca3af;">
                            This message was sent from the Peach Cream contact form.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
