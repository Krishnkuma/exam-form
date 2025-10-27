@extends('admin.dashboard')

@section('title', $title ?? 'Registration Forms')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Student Payment List</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Amount (₹)</th>
                    <th>Payment ID</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->user->email }}</td>
                    <td>{{ $payment->phone }}</td>
                    <td>{{ number_format($payment->amount / 100, 2) }}</td>
                    <td>{{ $payment->payment_id }}</td>
                    <td>
                        <a href="{{ asset('receipts/' . $payment->pdf) }}" target="_blank" class="btn btn-sm btn-primary">
                            Download PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
