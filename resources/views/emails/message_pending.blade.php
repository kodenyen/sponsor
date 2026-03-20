<!DOCTYPE html>
<html>
<head>
    <title>New Message Pending Approval</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Hello Admin,</h2>
    <p>A new message has been submitted in the IOI Scholarship System and is awaiting your approval.</p>
    
    <div style="background: #f4f4f4; padding: 15px; border-radius: 5px; border-left: 5px solid #005BFF;">
        <strong>Sender:</strong> {{ $sender_name }}<br>
        <strong>Content:</strong><br>
        {{ $message_content }}
    </div>

    <p>Please log in to the admin panel to review and approve/reject this message.</p>
    
    <p>
        <a href="{{ route('admin.messages') }}" style="background: #005BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Go to Moderation Panel
        </a>
    </p>

    <p>Thank you,<br>IOI Scholarship System</p>
</body>
</html>
