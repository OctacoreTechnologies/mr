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
                    <option value="">— Select a Customer —</option>
                    @foreach($customers as $c)
                        @php
                            $cpJson = $c->contact_persons;
                            if (empty($cpJson) && ($c->contact_person_1_name ?? null)) {
                                $cpJson = [[
                                    'name'        => $c->contact_person_1_name,
                                    'designation' => $c->contact_person_1_designation ?? '',
                                    'contact'     => $c->contact_person_1_contact ? [$c->contact_person_1_contact] : [],
                                    'email'       => $c->contact_person_1_email   ? [$c->contact_person_1_email]   : [],
                                ]];
                            }
                        @endphp
                        <option value="{{ $c->id }}"
                            data-contact-persons="{{ json_encode($cpJson ?? []) }}"
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

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 2: Contact Persons (multiple)
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-users"></i> Contact Persons
        </div>
        <div style="display:flex;align-items:center;gap:10px">
            <small style="color:#64748b;font-weight:400;font-size:.78rem">
                Contact persons will auto-fill when a customer is selected.
            </small>
            <button type="button" id="sf-add-person"
                    class="btn btn-sm btn-outline-primary"
                    style="font-size:.75rem;padding:4px 10px">
                <i class="fas fa-plus"></i> Add Person
            </button>
        </div>
    </div>
    <div class="crm-section-body">
        <div id="sf-persons-container"></div>
        <div id="sf-no-person"
             style="color:#94a3b8;font-size:.84rem;text-align:center;padding:18px 0;display:none">
            No contact persons added yet. Click <strong>Add Person</strong> to begin.
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 3: Upload Files
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-paperclip"></i> Upload Files
        </div>
        <small style="color:#64748b;font-weight:400;font-size:.78rem">JPG, PNG, PDF — multiple files allowed</small>
    </div>
    <div class="crm-section-body">

        {{-- Show existing files in edit mode --}}
        @if($isEdit && !empty($saleFormat->upload_file_path))
        <div id="existing-files-list" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px">
            @foreach((array)$saleFormat->upload_file_path as $filePath)
            @php $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)); @endphp
            <div class="existing-file-item" style="position:relative;display:inline-flex;align-items:center;gap:6px;padding:6px 10px;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:6px;font-size:.82rem">
                <input type="hidden" name="existing_files[]" value="{{ $filePath }}">
                @if(in_array($ext, ['jpg','jpeg','png','gif','svg']))
                    <img src="{{ asset($filePath) }}" style="height:40px;width:40px;object-fit:cover;border-radius:4px;border:1px solid #e2e8f0">
                @else
                    <i class="fas fa-file-pdf" style="font-size:1.6rem;color:#dc2626"></i>
                @endif
                <span style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($filePath) }}</span>
                <button type="button" class="remove-existing-file"
                        style="background:none;border:none;color:#dc2626;cursor:pointer;padding:0;line-height:1;font-size:1rem;flex-shrink:0"
                        title="Remove file">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            @endforeach
        </div>
        @endif

        <input type="file" name="upload_files[]" id="upload_files"
               class="crm-input"
               accept=".jpg,.jpeg,.png,.gif,.svg,.pdf"
               multiple>
        <small style="color:#94a3b8;font-size:.75rem">To select multiple files, hold <kbd>Ctrl</kbd> while clicking.</small>

        {{-- New file preview --}}
        <div id="new-files-preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:10px"></div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 4: Sale Details
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
     SECTION 5: Requirements
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
     SECTION 6: Remark & Sign-off
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
            <textarea name="remark" id="remark-ta" style="display:none;">{{ old('remark', $saleFormat->remark ?? '') }}</textarea>
            <div id="quill-remark" style="width:100%;min-height:150px;background:#fff;border-radius:6px;"></div>
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

@push('css')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
.sf-person-card{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;margin-bottom:14px}
.sf-person-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.sf-person-badge{background:#2563eb;color:#fff;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:20px;padding:4px 12px}
.sf-btn-rm-person{background:none;border:1px solid #fca5a5;color:#dc2626;border-radius:5px;font-size:.75rem;padding:3px 10px;cursor:pointer}
.sf-btn-rm-person:hover{background:#fee2e2}
.sf-person-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
@media(max-width:576px){.sf-person-grid{grid-template-columns:1fr}}
.sf-multi-wrap{margin-bottom:12px}
.sf-multi-list{display:flex;flex-direction:column;gap:6px;margin-top:6px;margin-bottom:6px}
.sf-multi-row{display:flex;align-items:center;gap:8px}
.sf-multi-input{flex:1}
.sf-btn-rm-entry{background:none;border:none;color:#dc2626;font-size:1.15rem;cursor:pointer;padding:0 4px;line-height:1;flex-shrink:0}
.sf-btn-rm-entry:hover{color:#b91c1c}
.sf-btn-add-entry{background:none;border:1px dashed #93c5fd;color:#3b82f6;border-radius:5px;font-size:.76rem;padding:4px 10px;cursor:pointer;margin-top:2px}
.sf-btn-add-entry:hover{background:#eff6ff;border-color:#3b82f6}
</style>
@endpush
@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {

    // ── Contact Persons Manager ──────────────────────────────────────────────
    (function () {
        var container  = document.getElementById('sf-persons-container');
        var noMsg      = document.getElementById('sf-no-person');
        var addBtn     = document.getElementById('sf-add-person');
        var customerSel = document.getElementById('customer_id');

        var initData = @json(old('contact_persons', $saleFormat->contact_persons ?? []));

        function esc(s) {
            return String(s || '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }

        function multiRows(idx, field, values) {
            if (!values || values.length === 0) values = [''];
            var type = field === 'email' ? 'email' : 'text';
            var ph   = field === 'email' ? 'email@example.com' : '+91 00000 00000';
            return values.map(function (v) {
                return '<div class="sf-multi-row">' +
                    '<input type="' + type + '" name="contact_persons[' + idx + '][' + field + '][]"' +
                    ' class="crm-input sf-multi-input" placeholder="' + ph + '" value="' + esc(v) + '">' +
                    '<button type="button" class="sf-btn-rm-entry" title="Remove">&times;</button>' +
                    '</div>';
            }).join('');
        }

        function makeCard(idx, data) {
            data = data || {};
            var div = document.createElement('div');
            div.className = 'sf-person-card';
            div.dataset.index = idx;
            div.innerHTML =
                '<div class="sf-person-header">' +
                    '<span class="sf-person-badge">Contact Person ' + (idx + 1) + '</span>' +
                    '<button type="button" class="sf-btn-rm-person">Remove</button>' +
                '</div>' +
                '<div class="sf-person-grid">' +
                    '<div class="crm-field-wrap">' +
                        '<label class="crm-field-label">Name</label>' +
                        '<input type="text" name="contact_persons[' + idx + '][name]" class="crm-input"' +
                        ' placeholder="Contact person name" value="' + esc(data.name) + '">' +
                    '</div>' +
                    '<div class="crm-field-wrap">' +
                        '<label class="crm-field-label">Designation</label>' +
                        '<input type="text" name="contact_persons[' + idx + '][designation]" class="crm-input"' +
                        ' placeholder="Job title" value="' + esc(data.designation) + '">' +
                    '</div>' +
                '</div>' +
                '<div class="sf-multi-wrap">' +
                    '<label class="crm-field-label"><i class="fas fa-phone" style="width:14px"></i> Contact Numbers</label>' +
                    '<div class="sf-multi-list" data-field="contact">' + multiRows(idx, 'contact', data.contact) + '</div>' +
                    '<button type="button" class="sf-btn-add-entry" data-field="contact">+ Add Contact Number</button>' +
                '</div>' +
                '<div class="sf-multi-wrap">' +
                    '<label class="crm-field-label"><i class="fas fa-envelope" style="width:14px"></i> Email Addresses</label>' +
                    '<div class="sf-multi-list" data-field="email">' + multiRows(idx, 'email', data.email) + '</div>' +
                    '<button type="button" class="sf-btn-add-entry" data-field="email">+ Add Email Address</button>' +
                '</div>';
            return div;
        }

        function reindex() {
            container.querySelectorAll('.sf-person-card').forEach(function (card, i) {
                card.dataset.index = i;
                card.querySelector('.sf-person-badge').textContent = 'Contact Person ' + (i + 1);
                card.querySelectorAll('input[name^="contact_persons["]').forEach(function (inp) {
                    inp.name = inp.name.replace(/contact_persons\[\d+\]/, 'contact_persons[' + i + ']');
                });
            });
        }

        function updateMsg() {
            noMsg.style.display = container.querySelectorAll('.sf-person-card').length ? 'none' : 'block';
        }

        function addPerson(data) {
            var idx = container.querySelectorAll('.sf-person-card').length;
            container.appendChild(makeCard(idx, data || {}));
            updateMsg();
        }

        // Event delegation
        container.addEventListener('click', function (e) {
            var rmPerson = e.target.closest('.sf-btn-rm-person');
            if (rmPerson) {
                rmPerson.closest('.sf-person-card').remove();
                reindex();
                updateMsg();
                return;
            }

            var rmEntry = e.target.closest('.sf-btn-rm-entry');
            if (rmEntry) {
                var list = rmEntry.closest('.sf-multi-list');
                var rows = list.querySelectorAll('.sf-multi-row');
                if (rows.length > 1) {
                    rmEntry.closest('.sf-multi-row').remove();
                } else {
                    list.querySelector('.sf-multi-input').value = '';
                }
                return;
            }

            var addEntry = e.target.closest('.sf-btn-add-entry');
            if (addEntry) {
                var field = addEntry.dataset.field;
                var card  = addEntry.closest('.sf-person-card');
                var idx2  = card.dataset.index;
                var mList = card.querySelector('.sf-multi-list[data-field="' + field + '"]');
                var row   = document.createElement('div');
                row.className = 'sf-multi-row';
                var isEmail = field === 'email';
                row.innerHTML =
                    '<input type="' + (isEmail ? 'email' : 'text') + '"' +
                    ' name="contact_persons[' + idx2 + '][' + field + '][]"' +
                    ' class="crm-input sf-multi-input"' +
                    ' placeholder="' + (isEmail ? 'email@example.com' : '+91 00000 00000') + '">' +
                    '<button type="button" class="sf-btn-rm-entry" title="Remove">&times;</button>';
                mList.appendChild(row);
                row.querySelector('input').focus();
            }
        });

        addBtn.addEventListener('click', function () { addPerson(); });

        // Auto-fill from customer dropdown
        function fillFromCustomer(opt) {
            try {
                var data = JSON.parse(opt.dataset.contactPersons || '[]');
                if (data && data.length) {
                    container.innerHTML = '';
                    data.forEach(function (p) { addPerson(p); });
                    updateMsg();
                }
            } catch (e) {}
        }

        customerSel.addEventListener('change', function () {
            var hasNames = Array.from(
                container.querySelectorAll('input[name$="[name]"]')
            ).some(function (inp) { return inp.value.trim() !== ''; });
            if (!hasNames) {
                fillFromCustomer(this.options[this.selectedIndex]);
            }
        });

        // Initial render
        if (initData && initData.length) {
            initData.forEach(function (p) { addPerson(p); });
        } else if (customerSel.value) {
            fillFromCustomer(customerSel.options[customerSel.selectedIndex]);
        } else {
            addPerson();
        }
        updateMsg();
    })();

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

    // ── Quill editor for Remark ──────────────────────────────────────────────
    var remarkTA = document.getElementById('remark-ta');
    var quillEl  = document.getElementById('quill-remark');

    if (remarkTA && quillEl && typeof Quill !== 'undefined') {
        var remarkEditor = new Quill(quillEl, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ indent: '-1' }, { indent: '+1' }],
                    ['link'],
                    [{ color: [] }, { background: [] }],
                    ['clean'],
                ]
            },
            placeholder: 'Enter any additional notes or special instructions...',
        });

        var existingRemark = remarkTA.value.trim();
        if (existingRemark) remarkEditor.clipboard.dangerouslyPasteHTML(existingRemark);

        remarkEditor.on('text-change', function () {
            remarkTA.value = remarkEditor.getSemanticHTML();
        });

        var saleForm = document.getElementById('saleFormatForm');
        if (saleForm) {
            saleForm.addEventListener('submit', function () {
                remarkTA.value = remarkEditor.getSemanticHTML();
            });
        }
    }

    // ── Existing files: remove button ────────────────────────────────────────
    var existingList = document.getElementById('existing-files-list');
    if (existingList) {
        existingList.addEventListener('click', function (e) {
            var btn = e.target.closest('.remove-existing-file');
            if (!btn) return;
            var item = btn.closest('.existing-file-item');
            // Disable hidden input so it won't be submitted
            var hiddenInput = item.querySelector('input[type="hidden"]');
            if (hiddenInput) hiddenInput.disabled = true;
            item.style.opacity = '0.35';
            item.style.textDecoration = 'line-through';
            btn.disabled = true;
        });
    }

    // ── New file input: preview selected files ───────────────────────────────
    var fileInput   = document.getElementById('upload_files');
    var previewArea = document.getElementById('new-files-preview');

    if (fileInput && previewArea) {
        fileInput.addEventListener('change', function () {
            previewArea.innerHTML = '';
            Array.from(this.files).forEach(function (file) {
                var item = document.createElement('div');
                item.style.cssText = 'display:inline-flex;align-items:center;gap:6px;padding:6px 10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;font-size:.82rem';

                var isPdf = file.type === 'application/pdf';
                if (isPdf) {
                    item.innerHTML = '<i class="fas fa-file-pdf" style="font-size:1.4rem;color:#dc2626"></i>';
                } else {
                    var img = document.createElement('img');
                    img.style.cssText = 'height:40px;width:40px;object-fit:cover;border-radius:4px;border:1px solid #e2e8f0';
                    img.src = URL.createObjectURL(file);
                    item.appendChild(img);
                }

                var name = document.createElement('span');
                name.style.cssText = 'max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap';
                name.textContent = file.name;
                item.appendChild(name);

                previewArea.appendChild(item);
            });
        });
    }

})();
</script>
@endpush
