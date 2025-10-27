@extends('student.dashboard')

@section('title', $title ?? 'Register')

@section('content')
{{-- {{dd($users);}} --}}
<div class="container mt-5">
    <div class="card shadow p-4" style="max-width: 600px; margin: auto;">
        <h4 class="mb-3 text-center">Student Registration Form</h4>

        <form id="registration-form">
            @csrf
            <div class="form-group mb-3">
                <label>Full Name</label>
                <input type="text" id="name" name="name" value="{{ $users->name }}" class="form-control" required disabled>
            </div>

            <div class="form-group mb-3">
                <label>Email Address</label>
                <input type="email" id="email" name="email" value = {{ $users->email }} class="form-control" required disabled>
            </div>

            <div class="form-group mb-3">
                <label>Mobile Number</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Registration Fee</label>
                <input type="text" class="form-control" value="₹500" readonly>
                <input type="hidden" id="plan" name="plan" value="basic">
                <input type="hidden" id="amount" name="amount" value="50000">
            </div>

            <button type="button" id="payBtn" class="btn btn-primary w-100">Pay ₹500 & Register</button>
        </form>

        <p id="message" class="text-center mt-3 text-muted"></p>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payBtn').addEventListener('click', async function () {
    const btn = this;
    btn.disabled = true;
    const messageEl = document.getElementById('message');
    messageEl.textContent = 'Creating order...';

    const data = {
        _token: document.querySelector('input[name=_token]').value,
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        plan: document.getElementById('plan').value,
        amount: document.getElementById('amount').value
    };

    try {
        const res = await fetch("{{ route('register.createOrder') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        });

        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Failed to create order.');

        const options = {
            key: json.key,
            amount: json.amount,
            currency: json.currency,
            name: 'Exam Registration',
            description: 'Registration Fee ₹500',
            order_id: json.order_id,
            handler: async function (response) {
                messageEl.textContent = 'Verifying payment...';

                const verify = await fetch("{{ route('register.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify({
                        ...response,
                        name: data.name,
                        email: data.email,
                        phone: data.phone,
                        plan: data.plan
                    })
                });

                const verifyJson = await verify.json();

                if (verifyJson.success) {
                    alert(verifyJson.message);
                    window.location.href = verifyJson.pdf_url;
                } else {
                    messageEl.textContent = verifyJson.message || 'Payment verification failed.';
                }
            },
            prefill: {
                name: data.name,
                email: data.email,
                contact: data.phone
            },
            theme: {
                color: '#007bff'
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();

        rzp.on('payment.failed', function (resp) {
            messageEl.textContent = 'Payment failed: ' + resp.error.description;
        });

    } catch (err) {
        console.error(err);
        messageEl.textContent = 'Error: ' + err.message;
    } finally {
        btn.disabled = false;
    }
});
</script>
@endsection
