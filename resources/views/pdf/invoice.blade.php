<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
</head>
<body>
<h1>Invoice for {{ $data['name'] }}</h1>
<p>Amount Due: ${{ $data['amount'] }}</p>
</body>
</html>
