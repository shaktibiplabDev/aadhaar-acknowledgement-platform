@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card shadow-sm border-0 rounded-3 bg-white">
                <!-- Purple Header with Wallet Badge -->
                <div class="card-header text-white d-flex justify-content-between align-items-center py-3 px-4" style="background-color: #6f42c1; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-child me-2"></i>New Child Enrolment (0-5 Years)</h5>
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
                    <div id="stepperChild" class="bs-stepper vertical">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#step-parent">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-parent" id="stepperChild-trigger-1">
                                    <span class="bs-stepper-circle"><i class="fas fa-user-shield"></i></span>
                                    <span class="bs-stepper-label">Parent / HOF Aadhaar</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-child">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-child" id="stepperChild-trigger-2">
                                    <span class="bs-stepper-circle"><i class="fas fa-child"></i></span>
                                    <span class="bs-stepper-label">Child Details</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-document">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-document" id="stepperChild-trigger-3">
                                    <span class="bs-stepper-circle"><i class="fas fa-file-alt"></i></span>
                                    <span class="bs-stepper-label">Birth Certificate</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-submit">
                                <button type="button" class="step-trigger" role="tab" aria-controls="step-submit" id="stepperChild-trigger-4">
                                    <span class="bs-stepper-circle"><i class="fas fa-check-circle"></i></span>
                                    <span class="bs-stepper-label">Review &amp; Submit</span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">
                            <form action="{{ route('retailer.child-enroll.store') }}" method="POST">
                                @csrf
                                <!-- Step 1: Parent -->
                                <div id="step-parent" class="content" role="tabpanel" aria-labelledby="stepperChild-trigger-1">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 1: Parent / Guardian Identification</h6>
                                    <div class="mb-3">
                                        <label for="sid" class="form-label fw-semibold">Enrolment ID / SID (Optional)</label>
                                        <input type="text" class="form-control" id="sid" name="sid" value="{{ old('sid') }}" placeholder="Enter SID or leave auto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="parent_aadhaar" class="form-label fw-semibold">Parent / HOF Aadhaar Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('parent_aadhaar') is-invalid @enderror" id="parent_aadhaar" name="parent_aadhaar" value="{{ old('parent_aadhaar') }}" required maxlength="12" placeholder="12-digit Parent Aadhaar">
                                        @error('parent_aadhaar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="parent_name" class="form-label fw-semibold">Parent / Guardian Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('parent_name') is-invalid @enderror" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Parent Full Name">
                                        @error('parent_name')
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
                                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="stepperChildObj.next()">Next <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- Step 2: Child Details -->
                                <div id="step-child" class="content" role="tabpanel" aria-labelledby="stepperChild-trigger-2">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 2: Child Personal Details</h6>
                                    <div class="mb-3">
                                        <label for="child_name" class="form-label fw-semibold">Child Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('child_name') is-invalid @enderror" id="child_name" name="child_name" value="{{ old('child_name') }}" required placeholder="Child Full Name">
                                        @error('child_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dob" class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" required max="{{ date('Y-m-d') }}">
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                <option value="">-- Select Gender --</option>
                                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                                                <option value="T" {{ old('gender') == 'T' ? 'selected' : '' }}>Transgender</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required placeholder="Residential Address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="pincode" class="form-label fw-semibold">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ old('pincode') }}" required maxlength="6" placeholder="6-digit Pincode">
                                        @error('pincode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="stepperChildObj.previous()"><i class="fas fa-arrow-left me-1"></i> Previous</button>
                                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="stepperChildObj.next()">Next <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- Step 3: Document -->
                                <div id="step-document" class="content" role="tabpanel" aria-labelledby="stepperChild-trigger-3">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 3: Birth Certificate &amp; Exemption Note</h6>
                                    <div class="mb-3">
                                        <label for="birth_certificate" class="form-label fw-semibold">Birth Certificate Ref / Document <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('birth_certificate') is-invalid @enderror" id="birth_certificate" name="birth_certificate" value="{{ old('birth_certificate') }}" required placeholder="Municipal Birth Certificate No.">
                                        @error('birth_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="alert alert-warning py-2 small">
                                        <i class="fas fa-info-circle me-1"></i> Minor biometric exemption applies for children under 5 years of age. Only facial photograph and parent authentication are captured.
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="stepperChildObj.previous()"><i class="fas fa-arrow-left me-1"></i> Previous</button>
                                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="stepperChildObj.next()">Next <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>
                                </div>

                                <!-- Step 4: Submit -->
                                <div id="step-submit" class="content" role="tabpanel" aria-labelledby="stepperChild-trigger-4">
                                    <h6 class="fw-bold mb-3 text-secondary">Step 4: Review and Submit</h6>
                                    <div class="alert alert-info py-2 small">
                                        Enrolment is free for children under 5 years (No charge). Parent authentication required.
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="confirmCheckChild" required>
                                        <label class="form-check-label small" for="confirmCheckChild">
                                            I confirm parent/guardian Aadhaar authentication has been verified successfully.
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="stepperChildObj.previous()"><i class="fas fa-arrow-left me-1"></i> Previous</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="fas fa-paper-plane me-1"></i> Submit Enrolment</button>
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
        window.stepperChildObj = new Stepper(document.querySelector('#stepperChild'));
    });
</script>
@endpush
@endsection
