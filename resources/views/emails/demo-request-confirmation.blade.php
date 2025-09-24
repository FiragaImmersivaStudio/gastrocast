<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Request Confirmation - CustiCast</title>
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
            background-color: #FFF3CD; 
            border: 1px solid #FFECB5; 
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
        .btn {
            display: inline-block;
            background-color: #7A001F;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">Thank You for Your Interest!</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">CustiCast Restaurant Intelligence Platform</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $data['full_name'] }},</p>
            
            <p>Thank you for requesting a demo of CustiCast! We're excited to show you how our AI-powered restaurant intelligence platform can help {{ $data['company'] }} optimize operations and boost profitability.</p>
            
            <div class="highlight">
                <strong>What happens next?</strong>
                <ul>
                    <li>Our sales team will contact you within <strong>24 hours</strong></li>
                    <li>We'll schedule a personalized demo at your convenience</li>
                    <li>The demo will be tailored to your restaurant's specific needs</li>
                    <li>You'll see real examples of forecasting, inventory optimization, and staff planning</li>
                </ul>
            </div>
            
            <p>In the meantime, feel free to visit our website to learn more about CustiCast's features:</p>
            
            <p style="text-align: center;">
                <a href="https://custicast.com" class="btn">Explore CustiCast</a>
            </p>
            
            <p>If you have any urgent questions, please don't hesitate to contact us directly:</p>
            <ul>
                <li><strong>Email:</strong> sales@custicast.com</li>
                <li><strong>Phone:</strong> +65 1234 5678</li>
            </ul>
            
            <p>We look forward to showing you the future of restaurant intelligence!</p>
            
            <p>Best regards,<br>
            <strong>CustiCast Sales Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated confirmation email. If you didn't request a demo, please contact us at sales@custicast.com</p>
        </div>
    </div>
</body>
</html>