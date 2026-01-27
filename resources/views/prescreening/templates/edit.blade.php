@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Edit Prescreening Template</h4>
                <p class="text-muted mb-0">
                    Modify template details and prescreening criteria
                </p>
            </div>

            <a href="{{ route('prescreening.templates.show', $template) }}" class="btn btn-outline-secondary btn-sm">
                Back
            </a>
        </div>

        <form method="POST" action="{{ route('prescreening.templates.update', $template) }}">
            @csrf
            @method('PUT')

            {{-- ================= TEMPLATE INFO ================= --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Template Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $template->name }}" required>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                @checked($template->is_active)>
                            <label class="form-check-label">
                                Active Template
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ $template->description }}</textarea>
                    </div>

                </div>
            </div>

            {{-- ================= CRITERIA ================= --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-semibold mb-0">Prescreening Criteria</h6>

                    <button type="button" class="btn btn-sm btn-primary" onclick="addCriterionRow()">
                        <i class="feather-plus me-1"></i> Add Criterion
                    </button>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered align-middle mb-0" id="criteriaTable">
                        <thead class="table-light">
                            <tr>
                                <th width="40">#</th>
                                <th>Label</th>
                                <th>Field Key</th>
                                <th>Type</th>
                                <th>Min Value</th>
                                <th>Mandatory</th>
                                <th width="60"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($template->criteria as $i => $criterion)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>
                                        <input type="text" name="criteria[{{ $i }}][name]"
                                            class="form-control label-input" value="{{ $criterion->name }}" required>
                                    </td>

                                    <td>
                                        <input type="text" name="criteria[{{ $i }}][field_key]"
                                            class="form-control field-key" value="{{ $criterion->field_key }}" readonly
                                            required>
                                    </td>

                                    <td>
                                        <select name="criteria[{{ $i }}][evaluation_type]" class="form-select"
                                            onchange="toggleMinValue(this)">
                                            <option value="yes_no" @selected($criterion->evaluation_type === 'yes_no')>Yes / No</option>
                                            <option value="exists" @selected($criterion->evaluation_type === 'exists')>Exists</option>
                                            <option value="numeric" @selected($criterion->evaluation_type === 'numeric')>Numeric</option>
                                        </select>
                                    </td>

                                    <td style="{{ $criterion->evaluation_type === 'numeric' ? '' : 'display:none;' }}">
                                        <input type="number" step="0.01"
                                            name="criteria[{{ $i }}][min_value]" class="form-control min-value"
                                            value="{{ $criterion->min_value }}"
                                            {{ $criterion->evaluation_type === 'numeric' ? '' : 'disabled' }}>
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox" name="criteria[{{ $i }}][is_mandatory]"
                                            value="1" @checked($criterion->is_mandatory)>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="this.closest('tr').remove()">
                                            <i class="feather-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================= ACTIONS ================= --}}
            <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-success">
                    <i class="feather-save me-1"></i> Update Template
                </button>
            </div>

        </form>
    </div>

    {{-- ================= JS ================= --}}
    <script>
        let rowIndex = {{ $template->criteria->count() }};

        function slugify(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s]/gi, '')
                .replace(/\s+/g, '_');
        }

        function toggleMinValue(selectEl) {
            const minInput = selectEl.closest('tr').querySelector('.min-value');
            const td = minInput.closest('td');

            if (selectEl.value === 'numeric') {
                minInput.removeAttribute('disabled');
                td.style.display = '';
            } else {
                minInput.value = '';
                minInput.setAttribute('disabled', 'disabled');
                td.style.display = 'none';
            }
        }

        function addCriterionRow() {
            const tbody = document.querySelector('#criteriaTable tbody');

            const row = document.createElement('tr');
            row.innerHTML = `
        <td>${rowIndex + 1}</td>

        <td>
            <input type="text"
                   name="criteria[${rowIndex}][name]"
                   class="form-control label-input"
                   required>
        </td>

        <td>
            <input type="text"
                   name="criteria[${rowIndex}][field_key]"
                   class="form-control field-key"
                   readonly required>
        </td>

        <td>
            <select name="criteria[${rowIndex}][evaluation_type]"
                    class="form-select"
                    onchange="toggleMinValue(this)">
                <option value="yes_no">Yes / No</option>
                <option value="exists">Exists</option>
                <option value="numeric">Numeric</option>
            </select>
        </td>

        <td style="display:none;">
            <input type="number"
                   step="0.01"
                   name="criteria[${rowIndex}][min_value]"
                   class="form-control min-value"
                   disabled>
        </td>

        <td class="text-center">
            <input type="checkbox"
                   name="criteria[${rowIndex}][is_mandatory]"
                   value="1"
                   checked>
        </td>

        <td class="text-center">
            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="this.closest('tr').remove()">
                <i class="feather-trash"></i>
            </button>
        </td>
    `;

            tbody.appendChild(row);

            const labelInput = row.querySelector('.label-input');
            const fieldKeyInput = row.querySelector('.field-key');

            labelInput.addEventListener('input', function() {
                fieldKeyInput.value = slugify(this.value);
            });

            rowIndex++;
        }
    </script>
@endsection
