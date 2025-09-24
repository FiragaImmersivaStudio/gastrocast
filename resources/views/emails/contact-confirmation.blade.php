<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Received - CustiCast</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            line-height: 1.6; 
            color: #333; 
            margin: 0; 
            padding: 20px; 
            background-color: #f8f9fa; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            overflow: hidden; 
        }
        .header { 
            background: linear-gradient(135deg, #7A001F, #5a0017); 
            color: white; 
            padding: 30px; 
            text-align: center; 
        }
        .content { 
            padding: 30px; 
        }
        .highlight { 
            background-color: #D4EDDA; 
            border: 1px solid #C3E6CB; 
            border-radius: 8px; 
            padding: 15px; 
            margin: 20px 0; 
        }
        .footer { 
            background-color: #f8f9fa; 
            padding: 20px; 
            text-align: center; 
            font-size: 14px; 
            color: #6c757d; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">Message Received</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">CustiCast Sales Team</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $data['full_name'] }},</p>
            
            <p>Thank you for contacting CustiCast! We've received your message and our sales team will get back to you shortly.</p>
            
            <div class="highlight">
                <strong>What you can expect:</strong>
                <ul>
                    <li>Our team will respond within <strong>2 business hours</strong></li>
                    <li>We'll provide detailed answers to your questions</li>
                    <li>If needed, we can schedule a call to discuss your requirements</li>
                </ul>
            </div>
            
            <p><strong>Your inquiry type:</strong> {{ ucwords(str_replace('-', ' ', $data['inquiry_type'] ?? 'General inquiry')) }}</p>
            
            <p>If you have any urgent questions in the meantime, please don't hesitate to contact us directly:</p>
            <ul>
                <li><strong>Email:</strong> sales@custicast.com</li>
                <li><strong>Phone:</strong> +65 1234 5678</li>
            </ul>
            
            <p>We're excited to help {{ $data['company'] }} optimize operations with AI-powered restaurant intelligence!</p>
            
            <p>Best regards,<br>
            <strong>CustiCast Sales Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated confirmation email. If you didn't send a message, please contact us at sales@custicast.com</p>
        </div>
    </div>
</body>
</html>