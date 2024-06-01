@extends('layouts.base')
@section('content')
    <div class="settings">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-merchant-tab" data-bs-toggle="pill" data-bs-target="#pills-merchant" type="button" role="tab" aria-controls="pills-merchant" aria-selected="true">Merchant Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-payment-tab" data-bs-toggle="pill" data-bs-target="#pills-payment" type="button" role="tab" aria-controls="pills-payment" aria-selected="false">Payment Info</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-merchant" role="tabpanel" aria-labelledby="pills-merchant-tab">
                <div class="card">
                    <div class="d-flex justify-content-end edit-icon">
                        <a href="{{ route('merchant.accountSettingForm') }}">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                    <p>Name: <span>{{ $merchant->first_name . ' ' . $merchant->last_name }}</span></p>
                    <p>Email: {{ $merchant->email }}</p>
                    <p>Phone: {{ $merchant->phone }}</p>
                    <p>Birthday: {{ $merchant->birth_day . '-' . $merchant->birth_month . '-' .  $merchant->birth_year }}</p>
                    <p>Business type: {{ ucwords($merchant->business_type) }}</p>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                <div class="card">
                    <p>Coming Soon</p>
                </div>
            </div>

        </div>
    </div>

<style>
    .settings .nav-pills .nav-item {
  width: 50%;
}
</style>
@endsection