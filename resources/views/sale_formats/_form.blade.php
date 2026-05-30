{{--
    Shared form partial — used by both create.blade.php and edit.blade.php
    Required variables: $customers, $saleFormat (new or existing SaleFormat)
    Optional: $selectedCustomer (pre-selects customer on create from customer page)
--}}

@php $isEdit = isset($saleFormat->id); @endphp

{{-- ══════════════════════════════════════════════════
     SECTION 1: Customer & Date
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-building"></i> Customer & Sale Info
        </div>
    </div>
    <div class="crm-section-body">
        <div class="crm-form-grid crm-form-grid-3">

            <div class="crm-field-wrap">
                <label class="crm-field-label">
                    Customer <span style="color:#DC2626">*</span>
                </label>
                <select id="customer_id" name="customer_id"
                        class="crm-select @error('customer_id') is-invalid @enderror">
                    <option value="">— Customer Select Karo —</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            data-cp-name="{{ $c->contact_person_1_name ?? '' }}"
                            data-cp-designation="{{ $c->contact_person_1_designation ?? '' }}"
                            data-cp-email="{{ $c->contact_person_1_email ?? '' }}"
                            data-cp-contact="{{ $c->contact_person_1_contact ?? '' }}"
                            {{ old('customer_id', $saleFormat->customer_id ?? $selectedCustomer?->id) == $c->id ? 'selected' : '' }}>
                            {{ $c->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div style="font-size:.78rem;color:#dc2626;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>

            <div class="crm-field-wrap">
                <label class="crm-field-label">
                   Date <span style="color:#DC2626">*</span>
                </label>
                <input type="date" name="sale_date"
                       class="crm-input @error('sale_date') is-invalid @enderror"
                       value="{{ old('sale_date', $saleFormat->sale_date?->format('Y-m-d') ?? date('Y-m-d')) }}">
                @error('sale_date')
                    <div style="font-size:.78rem;color:#dc2626;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>

              <div class="crm-field-wrap">
                        <label class="crm-field-label">Upload File</label>
                        <input type="file" name="upload_file_path" class="crm-input" accept=".jpg,.jpeg,.png,.gif,.svg">
            </div>

    

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 2: Contact Person
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-user"></i> Contact Person
        </div>
        <small style="color:#64748b;font-weight:400;font-size:.78rem">
            Customer select karte hi auto-fill hoga
        </small>
    </div>
    <div class="crm-section-body">
        <div class="crm-form-grid crm-form-grid-2">

            <div class="crm-field-wrap">
                <label class="crm-field-label">Name</label>
                <input type="text" id="cp_name" name="cp_name"
                       class="crm-input"
                       placeholder="Contact person name"
                       value="{{ old('cp_name', $saleFormat->cp_name ?? '') }}">
            </div>

            <div class="crm-field-wrap">
                <label class="crm-field-label">Designation</label>
                <input type="text" id="cp_designation" name="cp_designation"
                       class="crm-input"
                       placeholder="Job title"
                       value="{{ old('cp_designation', $saleFormat->cp_designation ?? '') }}">
            </div>

            <div class="crm-field-wrap">
                <label class="crm-field-label">Contact Number</label>
                <input type="text" id="cp_contact" name="cp_contact"
                       class="crm-input"
                       placeholder="+91 00000 00000"
                       value="{{ old('cp_contact', $saleFormat->cp_contact ?? '') }}">
            </div>

            <div class="crm-field-wrap">
                <label class="crm-field-label">Email</label>
                <input type="email" id="cp_email" name="cp_email"
                       class="crm-input"
                       placeholder="email@example.com"
                       value="{{ old('cp_email', $saleFormat->cp_email ?? '') }}">
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 3: Sale Details
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-cogs"></i> Sale Details
        </div>
        <button type="button" id="add-detail" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i> Add Row
        </button>
    </div>
    <div class="crm-section-body">

        {{-- Column labels --}}
        <div class="d-flex mb-2" style="gap:8px;padding-bottom:6px;border-bottom:1px solid #e2e8f0">
            <span style="min-width:26px"></span>
            <div style="flex:2;font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px">Application</div>
            <div style="flex:2;font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px">Model</div>
            <div style="flex:1;font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px">Output</div>
            <div style="min-width:66px"></div>
        </div>

        <div id="details-list">
            @php
                $details = old('sale_details',
                    $isEdit && $saleFormat->sale_details
                        ? $saleFormat->sale_details
                        : [['application' => '', 'model' => '', 'output' => '']]
                );
                if (empty($details)) {
                    $details = [['application' => '', 'model' => '', 'output' => '']];
                }
            @endphp

            @foreach($details as $i => $detail)
            <div class="d-flex align-items-center mb-2 detail-row" style="gap:8px">
                <span class="detail-num text-muted"
                      style="min-width:26px;text-align:right;font-size:.8rem;font-weight:600">
                    {{ $i + 1 }}.
                </span>
                <input type="text"
                       name="sale_details[{{ $i }}][application]"
                       class="crm-input"
                       style="flex:2"
                       placeholder="e.g. PVC Pipe"
                       value="{{ $detail['application'] ?? '' }}">
                <input type="text"
                       name="sale_details[{{ $i }}][model]"
                       class="crm-input"
                       style="flex:2"
                       placeholder="e.g. HSM-500"
                       value="{{ $detail['model'] ?? '' }}">
                <input type="text"
                       name="sale_details[{{ $i }}][output]"
                       class="crm-input"
                       style="flex:1"
                       placeholder="e.g. 500 Kg/Hr"
                       value="{{ $detail['output'] ?? '' }}">
                <button type="button"
                        class="btn btn-sm btn-outline-danger remove-detail"
                        style="padding:5px 10px;flex-shrink:0"
                        title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endforeach
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 4: Requirements
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-list-ul"></i> Requirements
        </div>
        <button type="button" id="add-req" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i> Add Row
        </button>
    </div>
    <div class="crm-section-body">
        <div id="requirements-list">
            @php
                $reqs = old('requirements',
                    $isEdit
                        ? $saleFormat->requirements->pluck('requirement_description')->toArray()
                        : ['']
                );
                if (empty($reqs)) { $reqs = ['']; }
            @endphp

            @foreach($reqs as $i => $req)
            <div class="d-flex align-items-center mb-2 req-row" style="gap:8px">
                <span class="req-num text-muted"
                      style="min-width:22px;text-align:right;font-size:.8rem;font-weight:600">
                    {{ $i + 1 }}.
                </span>
                <input type="text"
                       name="requirements[]"
                       class="crm-input"
                       style="flex:1"
                       placeholder="e.g. Mixer Machine 90 Kg/Batch with Vacuum Conveying System"
                       value="{{ $req }}">
                <button type="button"
                        class="btn btn-sm btn-outline-danger remove-req"
                        style="padding:5px 10px;flex-shrink:0"
                        title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 5: Remark & Sign-off
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-sticky-note"></i> Remark & Sign-off
        </div>
    </div>
    <div class="crm-section-body">

        <div class="crm-field-wrap mb-3">
            <label class="crm-field-label">Remark</label>
            <textarea name="remark" rows="3" class="crm-textarea"
                      placeholder="Koi notes ya special instructions...">{{ old('remark', $saleFormat->remark ?? '') }}</textarea>
        </div>

        <div class="crm-form-grid crm-form-grid-2">
            <div class="crm-field-wrap">
                <label class="crm-field-label">Prepared By</label>
                <input type="text" name="prepared_by"
                       class="crm-input"
                       placeholder="Name"
                       value="{{ old('prepared_by', $saleFormat->prepared_by ?? '') }}">
            </div>
            <div class="crm-field-wrap">
                <label class="crm-field-label">Approved By</label>
                <input type="text" name="approved_by"
                       class="crm-input"
                       placeholder="Name"
                       value="{{ old('approved_by', $saleFormat->approved_by ?? '') }}">
            </div>
        </div>

    </div>
</div>

@push('js')
<script>
(function () {

    // ── Auto-fill contact person from customer dropdown ──────────────────────
    var customerSel = document.getElementById('customer_id');

    function fillCP(opt) {
        document.getElementById('cp_name').value        = opt.dataset.cpName        || '';
        document.getElementById('cp_designation').value = opt.dataset.cpDesignation || '';
        document.getElementById('cp_email').value       = opt.dataset.cpEmail       || '';
        document.getElementById('cp_contact').value     = opt.dataset.cpContact     || '';
    }

    customerSel.addEventListener('change', function () {
        var cpName = document.getElementById('cp_name').value.trim();
        if (!cpName) {
            fillCP(this.options[this.selectedIndex]);
        }
    });

    // On page load: if customer selected and cp_name is empty, auto-fill
    if (customerSel.value && !document.getElementById('cp_name').value.trim()) {
        fillCP(customerSel.options[customerSel.selectedIndex]);
    }

    // ── Dynamic requirements list ────────────────────────────────────────────
    var list = document.getElementById('requirements-list');

    function reIndex() {
        var rows = list.querySelectorAll('.req-row');
        rows.forEach(function (row, i) {
            var num = row.querySelector('.req-num');
            if (num) num.textContent = (i + 1) + '.';
        });
    }

    function makeRow() {
        var div = document.createElement('div');
        div.className = 'd-flex align-items-center mb-2 req-row';
        div.style.gap = '8px';
        div.innerHTML =
            '<span class="req-num text-muted" style="min-width:22px;text-align:right;font-size:.8rem;font-weight:600"></span>' +
            '<input type="text" name="requirements[]" class="crm-input" style="flex:1"' +
            ' placeholder="e.g. Mixer Machine 90 Kg/Batch with Vacuum Conveying System">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-req"' +
            ' style="padding:5px 10px;flex-shrink:0" title="Remove">' +
            '<i class="fas fa-times"></i></button>';
        return div;
    }

    document.getElementById('add-req').addEventListener('click', function () {
        var row = makeRow();
        list.appendChild(row);
        reIndex();
        row.querySelector('input').focus();
    });

    list.addEventListener('click', function (e) {
        var btn = e.target.closest('.remove-req');
        if (!btn) return;
        var rows = list.querySelectorAll('.req-row');
        if (rows.length > 1) {
            btn.closest('.req-row').remove();
        } else {
            btn.closest('.req-row').querySelector('input').value = '';
        }
        reIndex();
    });

    reIndex();

    // ── Dynamic sale details list ────────────────────────────────────────────
    var detailList    = document.getElementById('details-list');
    var detailCounter = {{ count($details) }};

    function reIndexDetails() {
        detailList.querySelectorAll('.detail-row').forEach(function (row, i) {
            var num = row.querySelector('.detail-num');
            if (num) num.textContent = (i + 1) + '.';
        });
    }

    function makeDetailRow() {
        var idx = detailCounter++;
        var div = document.createElement('div');
        div.className = 'd-flex align-items-center mb-2 detail-row';
        div.style.gap = '8px';
        div.innerHTML =
            '<span class="detail-num text-muted" style="min-width:26px;text-align:right;font-size:.8rem;font-weight:600"></span>' +
            '<input type="text" name="sale_details[' + idx + '][application]" class="crm-input" style="flex:2" placeholder="e.g. PVC Pipe">' +
            '<input type="text" name="sale_details[' + idx + '][model]" class="crm-input" style="flex:2" placeholder="e.g. HSM-500">' +
            '<input type="text" name="sale_details[' + idx + '][output]" class="crm-input" style="flex:1" placeholder="e.g. 500 Kg/Hr">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-detail"' +
            ' style="padding:5px 10px;flex-shrink:0" title="Remove"><i class="fas fa-times"></i></button>';
        return div;
    }

    document.getElementById('add-detail').addEventListener('click', function () {
        var row = makeDetailRow();
        detailList.appendChild(row);
        reIndexDetails();
        row.querySelector('input').focus();
    });

    detailList.addEventListener('click', function (e) {
        var btn = e.target.closest('.remove-detail');
        if (!btn) return;
        var rows = detailList.querySelectorAll('.detail-row');
        if (rows.length > 1) {
            btn.closest('.detail-row').remove();
        } else {
            btn.closest('.detail-row').querySelectorAll('input').forEach(function (inp) {
                inp.value = '';
            });
        }
        reIndexDetails();
    });

    reIndexDetails();

})();
</script>
@endpush
