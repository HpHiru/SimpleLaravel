<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="text-align: center; color: #333;">OTP Verification</h2>
        <p style="text-align: center; color: #666;">Please use the following OTP to verify your email:</p>
        <div style="background-color: #f4f4f4; border-radius: 5px; padding: 20px; text-align: center;">
            <h3 style="color: #333; margin-bottom: 10px;">Your OTP:</h3>
            <p style="font-size: 24px; font-weight: bold; color: #007bff;">{{@$otp?:""}}</p>
        </div>
    </div>

</body>
</html>
