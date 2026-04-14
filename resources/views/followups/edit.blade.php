@extends('layouts.app')

@section('title', 'Edit Follow-up')

@php
    $quotation_id = request()->query('quotation_id') ?? null;
    $allowedExts  = ['pdf','xls','xlsx','csv','doc','docx','jpg','jpeg','png','gif','webp','svg','zip','rar'];
@endphp

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-calendar-check"></i>
        Quotation Follow-ups
    </h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- ── Validation Errors ── --}}
@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ══ FOLLOW-UP HISTORY ══ --}}
<div class="crm-index-card mb-4">
    <div class="card-header fu-history-toggle" id="historyToggle" title="Click to expand / collapse">
        <h3 class="card-title mb-0">
            <i class="fas fa-history"></i> Follow-up History
            @if(!$followups->isEmpty())
                <span class="fu-count-badge">{{ $followups->count() }}</span>
            @endif
        </h3>
        <div class="d-flex align-items-center" style="gap:10px;">
            <span class="fu-toggle-hint" id="toggleHint">Click to expand</span>
            <i class="fas fa-chevron-down fu-chevron" id="historyChevron"></i>
        </div>
    </div>
    <div class="fu-history-body" id="historyBody" style="display:none;">
        @if($followups->isEmpty())
            <div style="padding:16px 20px;">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle mr-2"></i> No follow-up history found.
                </div>
            </div>
        @else
            <div class="fu-table-scroll">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Follow-Up Date</th>
                            <th>Notes</th>
                            <th>Next Follow-Up</th>
                            <th>Documents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($followups as $index => $followup)
                            <tr>
                                <td class="sr-no">{{ $index + 1 }}</td>
                                <td>
                                    <span class="crm-date-cell">
                                        <i class="fas fa-calendar-day"></i>
                                        {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($followup->notes, 60, '...') }}</td>
                                <td>
                                    <span class="crm-date-cell">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($followup->next_follow_up_date)->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    @if($followup->documents->count())
                                        <span class="fu-doc-badge">
                                            <i class="fas fa-paperclip"></i>
                                            {{ $followup->documents->count() }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:.8rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- ══ FOLLOW-UP FORM ══ --}}
<div class="crm-card" style="margin-bottom: 90px;">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Manage Follow-up Entries
        </h3>
        <div class="d-flex align-items-center" style="gap: 10px;">
            <span class="fu-entry-count" id="entryCount"></span>
            <button type="button" class="btn btn-sm btn-outline-light" id="addRowBtn">
                <i class="fas fa-plus"></i> Add Entry
            </button>
        </div>
    </div>

    <div class="crm-card-body">
        <form action="{{ route('followup.update', $customer_id) }}"
              method="POST"
              id="followupForm"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Hidden: document IDs to delete (populated by JS) --}}
            <div id="deleteDocInputs"></div>

            <div id="followup-container">

                {{-- ── NEW (blank) row ── --}}
                <div class="followup-row followup-row--new" data-index="0">
                    <div class="followup-row-header">
                        <span class="followup-row-label">
                            <i class="fas fa-plus-circle"></i> New Entry
                        </span>
                        <button type="button" class="crm-remove-btn remove-followup">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>

                    <input type="hidden" name="follow_up_id[]" value="">
                    <input type="hidden" name="quotation_id" value="{{ $quotation_id }}">

                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input type="text"
                                name="follow_up_date[]"
                                label="Follow-Up Date"
                                fgroup-class="mb-3"
                                class="date-time" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input type="text"
                                name="next_follow_up_date[]"
                                label="Next Follow-Up Date"
                                fgroup-class="mb-3"
                                class="date-time" />
                        </div>
                        <div class="col-md-12">
                            <x-adminlte-textarea name="notes[]" label="Notes" fgroup-class="mb-3"></x-adminlte-textarea>
                        </div>
                        <div class="col-md-12">
                            <div class="fu-doc-upload-area" data-index="0">
                                <div class="fu-dropzone" id="dropzone-0">
                                    <i class="fas fa-cloud-upload-alt fu-drop-icon"></i>
                                    <p class="fu-drop-text">Drag & drop files or <span class="fu-drop-link">browse</span></p>
                                    <p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>
                                    <input type="file"
                                           name="documents[0][]"
                                           class="fu-file-input"
                                           multiple
                                           accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">
                                </div>
                                <div class="fu-file-list" id="fileList-0"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Existing rows ── --}}
                @foreach ($ofollowups as $index => $followup)
                    @php $rowIdx = $index + 1; @endphp
                    <div class="followup-row" data-index="{{ $rowIdx }}">
                        <div class="followup-row-header">
                            <span class="followup-row-label">
                                <i class="fas fa-calendar-check"></i> Entry #{{ $index + 1 }}
                                @if($followup->documents->count())
                                    <span class="fu-doc-badge ml-2">
                                        <i class="fas fa-paperclip"></i> {{ $followup->documents->count() }}
                                    </span>
                                @endif
                            </span>
                            <button type="button" class="crm-remove-btn remove-followup">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>

                        <input type="hidden" name="follow_up_id[]" value="{{ $followup->id }}">
                        <input type="hidden" name="quotation_id" value="{{ $quotation_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input type="text"
                                    name="follow_up_date[]"
                                    label="Follow-Up Date"
                                    value="{{ $followup->follow_up_date }}"
                                    fgroup-class="mb-3"
                                    class="date-time" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input type="text"
                                    name="next_follow_up_date[]"
                                    label="Next Follow-Up Date"
                                    value="{{ $followup->next_follow_up_date }}"
                                    fgroup-class="mb-3"
                                    class="date-time" />
                            </div>
                            <div class="col-md-12">
                                <x-adminlte-textarea name="notes[]" label="Notes" fgroup-class="mb-3">{{ $followup->notes }}</x-adminlte-textarea>
                            </div>

                            {{-- ── Existing Documents ── --}}
                            @if($followup->documents->count())
                                <div class="col-md-12 mb-3">
                                    <label class="fu-doc-section-label">
                                        <i class="fas fa-folder-open"></i> Existing Documents
                                    </label>
                                    <div class="fu-existing-docs" id="existingDocs-{{ $rowIdx }}">
                                        @foreach($followup->documents as $doc)
                                            <div class="fu-doc-chip" id="docChip-{{ $doc->id }}">
                                                <i class="{{ $doc->icon_class }} fu-chip-icon"></i>
                                                <div class="fu-chip-info">
                                                    <a href="{{ Storage::url($doc->file_path) }}"
                                                       target="_blank"
                                                       class="fu-chip-name"
                                                       title="{{ $doc->original_name }}">
                                                        {{ Str::limit($doc->original_name, 30, '...') }}
                                                    </a>
                                                    <span class="fu-chip-meta">{{ $doc->human_size }} · {{ strtoupper($doc->file_type) }}</span>
                                                </div>
                                                <button type="button"
                                                        class="fu-chip-delete"
                                                        data-doc-id="{{ $doc->id }}"
                                                        title="Remove document">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- ── New Document Upload ── --}}
                            <div class="col-md-12">
                                <div class="fu-doc-upload-area" data-index="{{ $rowIdx }}">
                                    <div class="fu-dropzone" id="dropzone-{{ $rowIdx }}">
                                        <i class="fas fa-cloud-upload-alt fu-drop-icon"></i>
                                        <p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span> to add more files</p>
                                        <p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>
                                        <input type="file"
                                               name="documents[{{ $rowIdx }}][]"
                                               class="fu-file-input"
                                               multiple
                                               accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">
                                    </div>
                                    <div class="fu-file-list" id="fileList-{{ $rowIdx }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>{{-- /followup-container --}}
        </form>
    </div>
</div>

{{-- ══ STICKY SAVE BAR ══ --}}
<div class="fu-sticky-bar" id="stickyBar">
    <div class="fu-sticky-inner">
        <div class="fu-sticky-info">
            <i class="fas fa-layer-group"></i>
            <span id="stickyInfo">— entries to save</span>
        </div>
        <div class="fu-sticky-actions">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" form="followupForm" class="btn btn-primary btn-sm">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>
</div>

@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <link rel="stylesheet" href="{{ asset('style/customerFollowup.css') }}">
@endpush

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/followup.js') }}">
    document.addEventListener('DOMContentLoaded', function () {

        /* ─── File-type → icon map ─── */
        const iconMap = {
            pdf:  'fas fa-file-pdf text-danger',
            xls:  'fas fa-file-excel text-success',
            xlsx: 'fas fa-file-excel text-success',
            csv:  'fas fa-file-csv text-success',
            doc:  'fas fa-file-word text-primary',
            docx: 'fas fa-file-word text-primary',
            jpg:  'fas fa-file-image text-warning',
            jpeg: 'fas fa-file-image text-warning',
            png:  'fas fa-file-image text-warning',
            gif:  'fas fa-file-image text-warning',
            webp: 'fas fa-file-image text-warning',
            svg:  'fas fa-file-image text-warning',
            zip:  'fas fa-file-archive text-secondary',
            rar:  'fas fa-file-archive text-secondary',
        };

        function getIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            return iconMap[ext] || 'fas fa-file text-muted';
        }

        function humanSize(bytes) {
            if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
            return (bytes / 1024).toFixed(1) + ' KB';
        }

        /* ─── Initialise dropzone for a row index ─── */
        function initDropzone(idx) {
            const zone     = document.getElementById(`dropzone-${idx}`);
            const listEl   = document.getElementById(`fileList-${idx}`);
            if (!zone) return;

            const fileInput = zone.querySelector('.fu-file-input');
            let   fileStore = [];   // DataTransfer accumulator

            function renderList() {
                listEl.innerHTML = '';
                fileStore.forEach((file, i) => {
                    const item = document.createElement('div');
                    item.className = 'fu-file-item';
                    item.innerHTML = `
                        <i class="${getIcon(file.name)}"></i>
                        <span class="fu-file-item-name" title="${file.name}">${file.name.length > 25 ? file.name.slice(0, 22) + '...' : file.name}</span>
                        <span class="fu-file-item-size">${humanSize(file.size)}</span>
                        <button type="button" class="fu-file-item-remove" data-i="${i}" title="Remove"><i class="fas fa-times"></i></button>
                    `;
                    listEl.appendChild(item);
                });

                // Sync fileInput files via DataTransfer
                const dt = new DataTransfer();
                fileStore.forEach(f => dt.items.add(f));
                fileInput.files = dt.files;
            }

            listEl.addEventListener('click', function (e) {
                const btn = e.target.closest('.fu-file-item-remove');
                if (btn) {
                    fileStore.splice(parseInt(btn.dataset.i), 1);
                    renderList();
                }
            });

            fileInput.addEventListener('change', function () {
                Array.from(this.files).forEach(f => fileStore.push(f));
                renderList();
            });

            zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
            zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
            zone.addEventListener('drop', function (e) {
                e.preventDefault();
                zone.classList.remove('drag-over');
                Array.from(e.dataTransfer.files).forEach(f => fileStore.push(f));
                renderList();
            });
        }

        /* Init all visible dropzones */
        document.querySelectorAll('.fu-dropzone').forEach(zone => {
            const idx = zone.closest('[data-index]').dataset.index;
            initDropzone(parseInt(idx));
        });

        /* ─── Delete existing document (AJAX) ─── */
        let rowDeleteTracker = {};  // track locally removed doc IDs per row

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.fu-chip-delete');
            if (!btn) return;

            const docId = btn.dataset.docId;
            const chip  = document.getElementById(`docChip-${docId}`);
            if (!chip) return;

            if (!confirm('Remove this document?')) return;

            chip.classList.add('removing');

            fetch(`customer/followup-document/${docId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.status) {
                    chip.remove();
                } else {
                    chip.classList.remove('removing');
                    alert('Failed to delete document.');
                }
            })
            .catch(() => {
                chip.classList.remove('removing');
                alert('Network error. Please try again.');
            });
        });

        /* ─── History toggle ─── */
        const toggle  = document.getElementById('historyToggle');
        const body    = document.getElementById('historyBody');
        const chevron = document.getElementById('historyChevron');
        const hint    = document.getElementById('toggleHint');

        toggle.addEventListener('click', function () {
            const open = body.style.display !== 'none';
            body.style.display  = open ? 'none' : 'block';
            chevron.classList.toggle('open', !open);
            hint.textContent = open ? 'Click to expand' : 'Click to collapse';
        });

        /* ─── Remove row ─── */
        document.getElementById('followup-container').addEventListener('click', function (e) {
            if (e.target.closest('.remove-followup')) {
                const row = e.target.closest('.followup-row');
                if (document.querySelectorAll('#followup-container .followup-row').length <= 1) {
                    alert('At least one follow-up entry is required.');
                    return;
                }
                row.remove();
                updateCount();
            }
        });

        /* ─── Add new row ─── */
        let nextIdx = {{ $ofollowups->count() + 1 }};

        document.getElementById('addRowBtn').addEventListener('click', function () {
            const html = `
            <div class="followup-row followup-row--new" data-index="${nextIdx}">
                <div class="followup-row-header">
                    <span class="followup-row-label">
                        <i class="fas fa-plus-circle"></i> New Entry
                    </span>
                    <button type="button" class="crm-remove-btn remove-followup">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <input type="hidden" name="follow_up_id[]" value="">
                <input type="hidden" name="quotation_id" value="{{ $quotation_id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Follow-Up Date</label>
                            <input type="text" name="follow_up_date[]" class="form-control date-time-new">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Next Follow-Up Date</label>
                            <input type="text" name="next_follow_up_date[]" class="form-control date-time-new">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label>Notes</label>
                            <textarea name="notes[]" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="fu-doc-upload-area" data-index="${nextIdx}">
                            <div class="fu-dropzone" id="dropzone-${nextIdx}">
                                <i class="fas fa-cloud-upload-alt fu-drop-icon"></i>
                                <p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span></p>
                                <p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>
                                <input type="file" name="documents[${nextIdx}][]" class="fu-file-input" multiple
                                    accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">
                            </div>
                            <div class="fu-file-list" id="fileList-${nextIdx}"></div>
                        </div>
                    </div>
                </div>
            </div>`;

            document.getElementById('followup-container').insertAdjacentHTML('afterbegin', html);

            // Init flatpickr on new fields
            document.querySelectorAll('.date-time-new').forEach(el => {
                flatpickr(el, {
                    enableTime: true,
                    dateFormat: "Y-m-d h:i K",
                    time_24hr: false,
                });
                el.classList.remove('date-time-new');
            });

            initDropzone(nextIdx);
            nextIdx++;
            updateCount();
        });

        /* ─── Entry count ─── */
        function updateCount() {
            const n = document.querySelectorAll('#followup-container .followup-row').length;
            document.getElementById('entryCount').textContent = n + (n === 1 ? ' entry' : ' entries');
            document.getElementById('stickyInfo').textContent = n + (n === 1 ? ' entry to save' : ' entries to save');
        }
        updateCount();

        /* ─── Flatpickr init ─── */
        flatpickr(".date-time", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K",
            time_24hr: false,
        });

    });
    </script>
@stop