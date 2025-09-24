<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Demo Request - CustiCast</title>
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
        .field { 
            margin-bottom: 20px; 
            padding-bottom: 15px; 
            border-bottom: 1px solid #eee; 
        }
        .field:last-child { 
            border-bottom: none; 
        }
        .label { 
            font-weight: bold; 
            color: #7A001F; 
            margin-bottom: 5px; 
            display: block; 
        }
        .value { 
            color: #555; 
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
            <h1 style="margin: 0; font-size: 24px;">New Demo Request</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">CustiCast Restaurant Intelligence Platform</p>
        </div>
        
        <div class="content">
            <p>A new demo request has been received through the CustiCast website:</p>
            
            <div class="field">
                <span class="label">Full Name:</span>
                <span class="value">{{ $data['full_name'] }}</span>
            </div>
            
            <div class="field">
                <span class="label">Email Address:</span>
                <span class="value">{{ $data['email'] }}</span>
            </div>
            
            <div class="field">
                <span class="label">Company/Restaurant:</span>
                <span class="value">{{ $data['company'] }}</span>
            </div>
            
            @if(!empty($data['phone']))
            <div class="field">
                <span class="label">Phone Number:</span>
                <span class="value">{{ $data['phone'] }}</span>
            </div>
            @endif
            
            @if(!empty($data['restaurant_type']))
            <div class="field">
                <span class="label">Restaurant Type:</span>
                <span class="value">{{ ucwords(str_replace('-', ' ', $data['restaurant_type'])) }}</span>
            </div>
            @endif
            
            @if(!empty($data['locations']))
            <div class="field">
                <span class="label">Number of Locations:</span>
                <span class="value">{{ $data['locations'] }}</span>
            </div>
            @endif
            
            @if(!empty($data['message']))
            <div class="field">
                <span class="label">Message:</span>
                <div class="value" style="white-space: pre-line;">{{ $data['message'] }}</div>
            </div>
            @endif
            
            <div class="field">
                <span class="label">Request Time:</span>
                <span class="value">{{ now()->format('F j, Y \a\t g:i A T') }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was generated automatically from the CustiCast website demo request form.</p>
            <p><strong>Please respond to this request within 24 hours for best customer experience.</strong></p>
        </div>
    </div>
</body>
</html>