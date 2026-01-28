@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Edit Program Funding</h4>
                <p class="text-muted mb-0">
                    Only draft funding records can be modified
                </p>
            </div>
            <a href="{{ route('finance.program-funding.show', $programFunding) }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <strong>Please correct the following:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <form method="POST" action="{{ route('finance.program-funding.update', $programFunding) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Program Name</label>
                            <input type="text" name="program_name" class="form-control"
                                value="{{ old('program_name', $programFunding->program_name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Funder</label>
                            <select name="funder_id" class="form-select" required>
                                <option value="">-- Select Funder --</option>
                                @foreach ($funders as $funder)
                                    <option value="{{ $funder->id }}"
                                        @selected(old('funder_id', $programFunding->funder_id) == $funder->id)>
                                        {{ $funder->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Governance Node</label>
                            <select name="governance_node_id" class="form-select" required>
                                <option value="">-- Select Node --</option>
                                @foreach ($nodes as $node)
                                    <option value="{{ $node->id }}"
                                        @selected($programFunding->governance_node_id == $node->id)>
                                        {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Approved Amount</label>
                            <input type="number" step="0.01" name="approved_amount"
                                value="{{ $programFunding->approved_amount }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Currency</label>
                            <input type="text" class="form-control currency-search mb-2"
                                placeholder="Search currency">
                            <select name="currency" class="form-select currency-select" required>
                                @php
                                    $currencyOptions = ['USD','EUR','GBP','GHS','KES','NGN','ZAR','UGX','TZS','RWF','XOF','XAF','EGP','MAD'];
                                @endphp
                                <option value="">-- Select Currency --</option>
                                @foreach ($currencyOptions as $currency)
                                    <option value="{{ $currency }}"
                                        @selected($programFunding->currency === $currency)>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Funding Type</label>
                            <select name="funding_type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                <option value="grant" @selected(old('funding_type', $programFunding->funding_type) === 'grant')>
                                    Grant
                                </option>
                                <option value="allocation" @selected(old('funding_type', $programFunding->funding_type) === 'allocation')>
                                    Government Allocation
                                </option>
                                <option value="capital" @selected(old('funding_type', $programFunding->funding_type) === 'capital')>
                                    Capital Injection
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>Start Year</label>
                            <input name="start_year" value="{{ $programFunding->start_year }}" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label>End Year</label>
                            <input name="end_year" value="{{ $programFunding->end_year }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        Editing is locked once submitted for approval.
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="feather-save me-1"></i> Update Funding
                        </button>
                        <a href="{{ route('finance.program-funding.show', $programFunding) }}" class="btn btn-light">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.currency-search').forEach(input => {
            const select = input.parentElement.querySelector('.currency-select');
            if (!select) return;

            input.addEventListener('input', () => {
                const term = input.value.toLowerCase();
                Array.from(select.options).forEach(option => {
                    if (option.value === '') {
                        option.hidden = false;
                        return;
                    }
                    option.hidden = term && !option.value.toLowerCase().includes(term);
                });
            });
        });
    </script>
@endsection
