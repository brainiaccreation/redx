@extends('admin.master.layouts.app')
@section('page-title')
    Transaction Detail
@endsection

@section('page-content')
    {{-- @component('admin.master.layouts.partials.breadcrumb')
        @slot('li_1')
            User
        @endslot
        @slot('title')
            Add
        @endslot
    @endcomponent --}}
    <div class="page-content">
        <div class="container-fluid mt-4">

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-3">Wallet Top-up Request Detail</h4>
                </div>
                <div class="card-body">
                    <p><strong>User:</strong> {{ $transaction->wallet->user->name }}
                        ({{ $transaction->wallet->user->email }})
                    </p>
                    <p><strong>Amount:</strong> {{ config('app.currency') }} {{ number_format($transaction->amount, 2) }}
                    </p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($transaction->payment_method) }}</p>
                    <p><strong>Status:</strong>
                        @php
                            $statusClass = match ($transaction->status) {
                                'pending' => 'bg-warning-subtle text-warning',
                                'approved' => 'bg-success-subtle text-success',
                                'rejected' => 'bg-secondary-subtle text-secondary',
                                default => 'bg-info-subtle text-info',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                    </p>

                    @if ($transaction->payment_method === 'bank' && $transaction->receipt_image)
                        <p><strong>Receipt Image:</strong></p>
                        <img src="{{ asset($transaction->receipt_image) }}" alt="Receipt Image"
                            class="img-fluid mb-3 rounded shadow" style="max-width: 400px;">
                    @endif

                    @if ($transaction->status === 'pending')
                        <form action="{{ route('admin.wallet.approve', $transaction->id) }}" method="POST">
                            @csrf


                            <div class="mt-3 d-flex gap-2">
                                <button name="action" value="approve" class="btn btn-success"
                                    onclick="return confirm('Are you sure you want to approve this top-up?')">Approve</button>
                                <button name="action" value="reject" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to reject this request?')">Reject</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
