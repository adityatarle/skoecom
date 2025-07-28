<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
</head>
<body>
    <h2>Pay with Razorpay</h2>
    <button id="pay-button">Pay ₹500</button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": "{{ $order->amount }}",
            "currency": "{{ $order->currency }}",
            "name": "Your Company Name",
            "description": "Test Transaction",
            "order_id": "{{ $order->id }}",
            "handler": function (response) {
                window.location.href = "/payment-success?razorpay_payment_id=" + response.razorpay_payment_id + 
                                      "&razorpay_order_id=" + response.razorpay_order_id + 
                                      "&razorpay_signature=" + response.razorpay_signature;
            },
            "prefill": {
                "name": "Test User",
                "email": "test@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('pay-button').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        };
    </script>
</body>
</html>
