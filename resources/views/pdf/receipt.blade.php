<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { text-align: center; padding: 40px; }
        h1 { color: #333; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        td { padding: 8px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Receipt</h1>
        <p>Thank you for your payment.</p>
        <table>
            <tr><td><strong>Name</strong></td><td>{{ $name }}</td></tr>
            <tr><td><strong>Email</strong></td><td>{{ $email }}</td></tr>
            <tr><td><strong>Amount</strong></td><td>{{ $amount }}</td></tr>
            <tr><td><strong>Payment ID</strong></td><td>{{ $payment_id }}</td></tr>
        </table>
    </div>
</body>
</html>
