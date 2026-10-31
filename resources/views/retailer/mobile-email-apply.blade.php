@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card shadow-sm border-0 rounded-3 bg-white">
                <!-- Purple Header with Wallet Badge -->
                <div class="card-header text-white d-flex justify-content-between align-items-center py-3 px-4" style="background-color: #6f42c1; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-address-book me-2"></i>Mobile &amp; Email Update Application</h5>
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-wallet me-1" style="color: #6f42c1;"></i> Wallet: ₹<span id="walletBalance">5,450.00</span>
                    </span>
                </div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- BS-Stepper Vertical Layout -->
                    <div id="stepperMobile" class="bs-stepper vertical">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#step-aadhaar">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-aadhaar" id="stepperMobile-trigger-1">
                                    <span class="bs-stepper-circle"><i class="fas fa-id-card"></i></span>
                                    <span class="bs-stepper-label">Resident &amp; Aadhaar</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-details">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-details" id="stepperMobile-trigger-2">
                                    <span class="bs-stepper-circle"><i class="fas fa-phone-alt"></i></span>
                                    <span class="bs-stepper-label">Contact Details</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-submit">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-submit" id="stepperMobile-trigger-3">
                                    <span class="bs-stepper-circle"><i class="fas fa-check-circle"></i></span>
                                    <span class="bs-stepper-label">Review &amp; Submit</span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">
                            <form action="{{ route('retailer.mobile-email.store') }}" method="POST">
                                @csrf
                                <!-- Step 1: Aadhaar -->
                                <div id="step-aadhaar" class="content" role="tabpanel" aria-labelledby="stepperMobile-trigger-1">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 1: Resident Identification</h6>
                                    <div class="mb-3">
                                        <label for="sid" class="form-label fw-semibold">Enrolment ID / SID (Optional)</label>
                                        <input type="text" class="form-control" id="sid" name="sid" value="{{ old('sid') }}" placeholder="Enter SID or leave auto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="aadhaar_number" class="form-label fw-semibold">Aadhaar Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('aadhaar_number') is-invalid @enderror" id="aadhaar_number" name="aadhaar_number" value="{{ old('aadhaar_number') }}" required maxlength="12" placeholder="12-digit Aadhaar Number">
                                        @error('aadhaar_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="operator_id" class="form-label fw-semibold">Operator ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('operator_id') is-invalid @enderror" id="operator_id" name="operator_id" value="{{ old('operator_id', auth()->user()->operator_id ?? 'OP1001') }}" required placeholder="Operator ID">
                                        @error('operator_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="stepperMobileObj.next()">Next <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- Step 2: Details -->
                                <div id="step-details" class="content" role="tabpanel" aria-labelledby="stepperMobile-trigger-2">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 2: Enter Mobile &amp; Email</h6>
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" maxlength="10" placeholder="10-digit Mobile Number">
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="resident@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text text-muted mb-3">At least either mobile number or email address must be provided.</div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="stepperMobileObj.previous()"><i class="fas fa-arrow-left me-1"></i> Previous</button>
                                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="stepperMobileObj.next()">Next <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- Step 3: Submit -->
                                <div id="step-submit" class="content" role="tabpanel" aria-labelledby="stepperMobile-trigger-3">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 3: Review and Submit</h6>
                                    <div class="alert alert-info py-2 small">
                                        Please verify contact details before submission. Fee: ₹50.00 will be deducted from your retailer wallet.
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="confirmCheckMobile" required>
                                        <label class="form-check-label small" for="confirmCheckMobile">
                                            I confirm biometric authentication for contact update is completed.
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="stepperMobileObj.previous()"><i class="fas fa-arrow-left me-1"></i> Previous</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="fas fa-paper-plane me-1"></i> Submit Application</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.stepperMobileObj = new Stepper(document.querySelector('#stepperMobile'));
    });
</script>
@endpush
@endsection
