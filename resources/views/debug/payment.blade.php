<title>{{ $title }}</title>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.payment.client_key') }}"></script>
<button id="pay-button">Pay!</button>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    // For example trigger on button clicked, or any time you need
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $key }}'); // Replace it with your transaction token
    });

</script>
