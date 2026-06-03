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
        <div class="crm-form-grid crm-form-grid-2">

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
        <button type="button" id="sf-add-person"
                class="btn btn-sm btn-outline-light"
                style="font-size:.75rem;padding:4px 12px">
            <i class="fas fa-plus"></i> Add Person
        </button>
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
     SECTION 3: Sale Details
══════════════════════════════════════════════════ --}}
<div class="crm-section-card">
    <div class="crm-section-header">
        <div class="sec-title">
            <i class="fas fa-cogs"></i> Sale Details
        </div>
        <button type="button" id="add-detail" class="btn btn-sm btn-outline-light">
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
        <button type="button" id="add-req" class="btn btn-sm btn-outline-light">
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
/* ── Person Card ── */
.sf-person-card{background:#fff;border:1px solid #e2e8f0;border-left:3px solid #2563eb;border-radius:10px;margin-bottom:14px;overflow:hidden}
.sf-person-header{display:flex;justify-content:space-between;align-items:center;padding:10px 16px;background:#f0f6ff;border-bottom:1px solid #dbeafe}
.sf-person-badge{background:#2563eb;color:#fff;font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:20px;padding:3px 12px}
.sf-person-body{padding:16px}
.sf-btn-rm-person{background:none;border:1px solid #fca5a5;color:#dc2626;border-radius:5px;font-size:.73rem;padding:3px 10px;cursor:pointer;display:flex;align-items:center;gap:4px}
.sf-btn-rm-person:hover{background:#fee2e2}
/* ── Field layout inside card ── */
.sf-person-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
.sf-field-group{display:flex;flex-direction:column}
@media(max-width:576px){.sf-person-grid{grid-template-columns:1fr}}
/* ── Multi-entry rows (phone / email) ── */
.sf-multi-list{display:flex;flex-direction:column;gap:5px;margin-top:5px;margin-bottom:5px}
.sf-multi-row{display:flex;align-items:center;gap:6px}
.sf-multi-input{flex:1;min-width:0}
.sf-btn-rm-entry{background:none;border:none;color:#dc2626;font-size:1.1rem;cursor:pointer;padding:0 3px;line-height:1;flex-shrink:0}
.sf-btn-rm-entry:hover{color:#b91c1c}
.sf-btn-add-entry{align-self:flex-start;background:none;border:1px dashed #93c5fd;color:#3b82f6;border-radius:5px;font-size:.73rem;padding:3px 9px;cursor:pointer;margin-top:3px}
.sf-btn-add-entry:hover{background:#eff6ff;border-color:#3b82f6}
/* ── Attachments ── */
.sf-docs-wrap{padding-top:12px;margin-top:2px;border-top:1px dashed #e2e8f0}
.sf-existing-docs-list{display:flex;flex-direction:column;gap:4px;margin-top:6px;margin-bottom:8px}
.sf-existing-doc{display:flex;align-items:center;gap:7px;padding:5px 9px;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:5px;font-size:.8rem}
.sf-existing-doc-name{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#334155}
.sf-btn-rm-doc{background:none;border:none;color:#dc2626;font-size:1.05rem;cursor:pointer;padding:0 3px;line-height:1;flex-shrink:0}
.sf-btn-rm-doc:hover{color:#b91c1c}
.sf-doc-preview{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.sf-doc-preview-item{display:inline-flex;align-items:center;gap:5px;padding:4px 8px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:5px;font-size:.77rem}
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

        @php
            $initPersons = old('contact_persons', $saleFormat->contact_persons ?? []);
            if ($isEdit && !empty($saleFormat->upload_file_path)) {
                $migrateFiles = array_values(array_filter((array)$saleFormat->upload_file_path));
                if (!empty($migrateFiles)) {
                    $initPersons = array_values((array)$initPersons);
                    if (empty($initPersons)) {
                        $initPersons = [['name'=>'','designation'=>'','contact'=>[],'email'=>[],'documents'=>$migrateFiles]];
                    } else {
                        $existingDocs = array_values(array_filter($initPersons[0]['documents'] ?? []));
                        $initPersons[0]['documents'] = array_values(array_unique([...$existingDocs, ...$migrateFiles]));
                    }
                }
            }
        @endphp
        var initData = @json($initPersons);

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

        function buildExistingDocsHtml(idx, docs) {
            if (!docs || !docs.length) return '';
            var html = '<div class="sf-existing-docs-list">';
            docs.forEach(function (docPath) {
                if (!docPath) return;
                var ext   = docPath.split('.').pop().toLowerCase();
                var isImg = ['jpg','jpeg','png','gif','svg'].indexOf(ext) !== -1;
                var isPdf = ext === 'pdf';
                html +=
                    '<div class="sf-existing-doc">' +
                    '<input type="hidden" name="person_existing_docs[' + idx + '][]" value="' + esc(docPath) + '">' +
                    (isPdf
                        ? '<i class="fas fa-file-pdf" style="color:#dc2626;font-size:1.05rem;flex-shrink:0"></i>'
                        : isImg
                            ? '<img src="/' + esc(docPath) + '" style="height:26px;width:26px;object-fit:cover;border-radius:3px;border:1px solid #e2e8f0;flex-shrink:0" alt="">'
                            : '<i class="fas fa-file" style="color:#64748b;font-size:1.05rem;flex-shrink:0"></i>'
                    ) +
                    '<span class="sf-existing-doc-name" title="' + esc(docPath) + '">' +
                        esc(docPath.split(/[/\\]/).pop()) +
                    '</span>' +
                    '<button type="button" class="sf-btn-rm-doc" title="Remove this attachment">&times;</button>' +
                    '</div>';
            });
            html += '</div>';
            return html;
        }

        function makeCard(idx, data) {
            data = data || {};
            var div = document.createElement('div');
            div.className = 'sf-person-card';
            div.dataset.index = idx;
            div.innerHTML =
                '<div class="sf-person-header">' +
                    '<span class="sf-person-badge">Contact Person ' + (idx + 1) + '</span>' +
                    '<button type="button" class="sf-btn-rm-person">' +
                        '<i class="fas fa-times" style="font-size:.65rem"></i> Remove' +
                    '</button>' +
                '</div>' +
                '<div class="sf-person-body">' +
                    /* Row 1: Name + Designation */
                    '<div class="sf-person-grid">' +
                        '<div class="crm-field-wrap">' +
                            '<label class="crm-field-label">Full Name</label>' +
                            '<input type="text" name="contact_persons[' + idx + '][name]" class="crm-input"' +
                            ' placeholder="e.g. Rahul Sharma" value="' + esc(data.name) + '">' +
                        '</div>' +
                        '<div class="crm-field-wrap">' +
                            '<label class="crm-field-label">Designation</label>' +
                            '<input type="text" name="contact_persons[' + idx + '][designation]" class="crm-input"' +
                            ' placeholder="e.g. Purchase Manager" value="' + esc(data.designation) + '">' +
                        '</div>' +
                    '</div>' +
                    /* Row 2: Contact Numbers | Email Addresses — side by side */
                    '<div class="sf-person-grid">' +
                        '<div class="sf-field-group">' +
                            '<label class="crm-field-label">' +
                                '<i class="fas fa-phone" style="width:13px;color:#64748b"></i> Contact Numbers' +
                            '</label>' +
                            '<div class="sf-multi-list" data-field="contact">' + multiRows(idx, 'contact', data.contact) + '</div>' +
                            '<button type="button" class="sf-btn-add-entry" data-field="contact">+ Add Number</button>' +
                        '</div>' +
                        '<div class="sf-field-group">' +
                            '<label class="crm-field-label">' +
                                '<i class="fas fa-envelope" style="width:13px;color:#64748b"></i> Email Addresses' +
                            '</label>' +
                            '<div class="sf-multi-list" data-field="email">' + multiRows(idx, 'email', data.email) + '</div>' +
                            '<button type="button" class="sf-btn-add-entry" data-field="email">+ Add Email</button>' +
                        '</div>' +
                    '</div>' +
                    /* Row 3: Attachments */
                    '<div class="sf-docs-wrap">' +
                        '<label class="crm-field-label">' +
                            '<i class="fas fa-paperclip" style="width:13px;color:#64748b"></i> Attachments' +
                        '</label>' +
                        buildExistingDocsHtml(idx, data.documents) +
                        '<input type="file" name="person_documents[' + idx + '][]"' +
                        ' class="crm-input sf-doc-input" accept=".jpg,.jpeg,.png,.gif,.svg,.pdf" multiple' +
                        ' style="margin-top:6px">' +
                        '<small style="color:#94a3b8;font-size:.73rem;display:block;margin-top:3px">' +
                            'JPG, PNG, PDF — max 5 MB. Hold <kbd>Ctrl</kbd> to pick multiple.' +
                        '</small>' +
                        '<div class="sf-doc-preview"></div>' +
                    '</div>' +
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
                card.querySelectorAll('input[name^="person_documents["]').forEach(function (inp) {
                    inp.name = inp.name.replace(/person_documents\[\d+\]/, 'person_documents[' + i + ']');
                });
                card.querySelectorAll('input[name^="person_existing_docs["]').forEach(function (inp) {
                    inp.name = inp.name.replace(/person_existing_docs\[\d+\]/, 'person_existing_docs[' + i + ']');
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

            var rmDoc = e.target.closest('.sf-btn-rm-doc');
            if (rmDoc) {
                var docItem   = rmDoc.closest('.sf-existing-doc');
                var hiddenInp = docItem.querySelector('input[type="hidden"]');
                if (hiddenInp) hiddenInp.disabled = true;
                docItem.style.opacity        = '0.4';
                docItem.style.textDecoration = 'line-through';
                rmDoc.disabled = true;
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

        // File preview for per-person attachments
        container.addEventListener('change', function (e) {
            if (!e.target.classList.contains('sf-doc-input')) return;
            var wrap    = e.target.closest('.sf-docs-wrap');
            var preview = wrap ? wrap.querySelector('.sf-doc-preview') : null;
            if (!preview) return;
            preview.innerHTML = '';
            Array.from(e.target.files).forEach(function (file) {
                var item = document.createElement('div');
                item.className = 'sf-doc-preview-item';
                if (file.type === 'application/pdf') {
                    item.innerHTML = '<i class="fas fa-file-pdf" style="font-size:1.1rem;color:#dc2626"></i>';
                } else {
                    var img   = document.createElement('img');
                    img.style.cssText = 'height:28px;width:28px;object-fit:cover;border-radius:3px;border:1px solid #e2e8f0';
                    img.src   = URL.createObjectURL(file);
                    item.appendChild(img);
                }
                var name = document.createElement('span');
                name.textContent = file.name;
                item.appendChild(name);
                preview.appendChild(item);
            });
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


})();
</script>
@endpush
