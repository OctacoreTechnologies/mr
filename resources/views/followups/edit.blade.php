@extends('layouts.app')
 
@section('title', 'Edit Follow-up')
 
@php
    $quotation_id    =    request()->query('quotation_id') ?? null;
    $opportunity_id  =    request()->query('opportunity_id') ?? null;
    $type            =    request()->query('type') ?? null;  

@endphp
 
@section('content_header')
<div class="crm-page-header">
    <h1><i class="fas fa-calendar-check"></i> Customer Follow-ups</h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop
 
@section('content')
 
{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1 pl-3">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif
 
{{-- ══════════════════════════════════════════
     FOLLOW-UP HISTORY (Collapsible)
══════════════════════════════════════════ --}}
<div class="crm-index-card mb-4">
    <div class="card-header fu-history-toggle" id="historyToggle">
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
            <div class="fu-history-list">
                @foreach ($followups as $hi => $hfu)
                @php
                    $hDocCount = $hfu->documents->count();
                @endphp
 
                {{-- ── History Item ── --}}
                <div class="fu-history-item" id="histItem-{{ $hi }}">
 
                    {{-- Summary row (always visible) --}}
                    <div class="fu-history-summary" data-hi="{{ $hi }}">
                        <div class="fu-history-summary-left">
                            <span class="fu-history-num">{{ $hi + 1 }}</span>
                            <div class="fu-history-dates">
                                <span class="fu-hist-date-pill fu-hist-date-pill--fu">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($hfu->follow_up_date)->format('d M Y, h:i A') }}
                                </span>
                                <i class="fas fa-arrow-right fu-hist-arrow"></i>
                                <span class="fu-hist-date-pill fu-hist-date-pill--next">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($hfu->next_follow_up_date)->format('d M Y, h:i A') }}
                                </span>
                            </div>
                            @if($hDocCount)
                                <span class="fu-hist-doc-badge">
                                    <i class="fas fa-paperclip"></i> {{ $hDocCount }}
                                </span>
                            @endif
                        </div>
                        <button class="fu-hist-expand-btn" data-hi="{{ $hi }}" title="View full details">
                            <i class="fas fa-chevron-down fu-hist-chevron" id="histChev-{{ $hi }}"></i>
                        </button>
                    </div>
 
                    {{-- Detail panel (expand/collapse) --}}
                    <div class="fu-history-detail" id="histDetail-{{ $hi }}" style="display:none;">
 
                        {{-- Full Notes --}}
                        <div class="fu-hist-section">
                            <div class="fu-hist-section-label">
                                <i class="fas fa-file-alt"></i> Discussion Notes
                            </div>
                            @if($hfu->notes)
                                <div class="fu-rich-content fu-hist-notes">
                                   {!! $hfu->notes !!}
                                </div>
                            @else
                                <p class="fu-hist-empty">No notes added.</p>
                            @endif
                        </div>
 
                        {{-- Documents --}}
                        @if($hDocCount)
                        <div class="fu-hist-section">
                            <div class="fu-hist-section-label">
                                <i class="fas fa-folder-open"></i> Attached Documents
                                <span class="fu-hist-doc-count">{{ $hDocCount }} {{ Str::plural('file', $hDocCount) }}</span>
                            </div>
                            <div class="fu-hist-docs-grid">
                                @foreach($hfu->documents as $hdoc)
                                    <a href="{{ Storage::url($hdoc->file_path) }}"
                                       target="_blank"
                                       class="fu-hist-doc-tile"
                                       title="{{ $hdoc->original_name }}">
                                        @if($hdoc->is_image)
                                            <div class="fu-hist-doc-thumb">
                                                <img src="{{ Storage::url($hdoc->file_path) }}"
                                                     alt="{{ $hdoc->original_name }}"
                                                     loading="lazy">
                                            </div>
                                        @else
                                            <div class="fu-hist-doc-icon">
                                                <i class="{{ $hdoc->icon_class }}"></i>
                                            </div>
                                        @endif
                                        <div class="fu-hist-doc-info">
                                            <span class="fu-hist-doc-name" title="{{ $hdoc->original_name }}">
                                                {{ Str::limit($hdoc->original_name, 26, '…') }}
                                            </span>
                                            <span class="fu-hist-doc-meta">
                                                {{ $hdoc->human_size }} · {{ strtoupper($hdoc->file_type) }}
                                            </span>
                                        </div>
                                        <span class="fu-hist-doc-dl"><i class="fas fa-download"></i></span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                            <div class="fu-hist-section">
                                <div class="fu-hist-section-label">
                                    <i class="fas fa-folder-open"></i> Attached Documents
                                </div>
                                <p class="fu-hist-empty">No documents attached.</p>
                            </div>
                        @endif
 
                    </div>{{-- /fu-history-detail --}}
                </div>{{-- /fu-history-item --}}
                @endforeach
            </div>
        @endif
    </div>
</div>
 
{{-- ══════════════════════════════════════════
     FOLLOW-UP FORM
══════════════════════════════════════════ --}}
<div class="crm-card" style="margin-bottom: 90px;">
    <div class="crm-card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Manage Follow-up Entries
        </h3>
        <div class="d-flex align-items-center" style="gap:10px;">
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
 
            <div id="followup-container">
 
                {{-- ── NEW blank row ── --}}
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
                    <input type="hidden" name="opportunity_id" value="{{ $opportunity_id }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input type="text" name="follow_up_date[]"
                                label="Follow-Up Date" fgroup-class="mb-3" class="date-time"/>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input type="text" name="next_follow_up_date[]"
                                label="Next Follow-Up Date" fgroup-class="mb-3" class="date-time"/>
                        </div>
                        <div class="col-md-12">
                            <div class="fu-editor-wrap mb-3">
                                <label class="fu-editor-label">
                                    <i class="fas fa-align-left"></i> Notes
                                    <span class="fu-editor-hint">Bullets, numbering, bold — format discussion points</span>
                                </label>
                                <textarea name="notes[]" class="fu-notes-hidden" style="display:none;"></textarea>
                                <div class="fu-quill-editor" id="quill-0"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fu-doc-upload-area">
                                <div class="fu-dropzone" id="dropzone-0">
                                    <i class="fas fa-cloud-upload-alt fu-drop-icon"></i>
                                    <p class="fu-drop-text">Drag & drop files or <span class="fu-drop-link">browse</span></p>
                                    <p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>
                                    <input type="file" name="documents[]" class="fu-file-input" multiple
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
                    <input type="hidden" name="quotation_id" value="{{ $followup->quotation_id }}">
                    <input type="hidden" name="opportunity_id" value="{{ $opportunity_id??$followup->opportunity_id }}"> 
 
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input type="text" name="follow_up_date[]"
                                label="Follow-Up Date" value="{{ $followup->follow_up_date }}"
                                fgroup-class="mb-3" class="date-time"/>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input type="text" name="next_follow_up_date[]"
                                label="Next Follow-Up Date" value="{{ $followup->next_follow_up_date }}"
                                fgroup-class="mb-3" class="date-time"/>
                        </div>
                        <div class="col-md-12">
                            <div class="fu-editor-wrap mb-3">
                                <label class="fu-editor-label">
                                    <i class="fas fa-align-left"></i> Notes
                                    <span class="fu-editor-hint">Bullets, numbering, bold — format discussion points</span>
                                </label>
                                <textarea name="notes[]" class="fu-notes-hidden"
                                    data-content="{{ htmlspecialchars($followup->notes ?? '', ENT_QUOTES) }}"
                                    style="display:none;"></textarea>
                                <div class="fu-quill-editor" id="quill-{{ $rowIdx }}"></div>
                            </div>
                        </div>
 
                        {{-- Existing documents --}}
                        @if($followup->documents->count())
                        <div class="col-md-12 mb-3">
                            <label class="fu-doc-section-label">
                                <i class="fas fa-folder-open"></i> Existing Documents
                            </label>
                            <div class="fu-existing-docs">
                                @foreach($followup->documents as $doc)
                                <div class="fu-doc-chip" id="docChip-{{ $doc->id }}">
                                    <i class="{{ $doc->icon_class }} fu-chip-icon"></i>
                                    <div class="fu-chip-info">
                                        <a href="{{ Storage::url($doc->file_path) }}"
                                           target="_blank" class="fu-chip-name"
                                           title="{{ $doc->original_name }}">
                                            {{ Str::limit($doc->original_name, 30, '...') }}
                                        </a>
                                        <span class="fu-chip-meta">{{ $doc->human_size }} · {{ strtoupper($doc->file_type) }}</span>
                                    </div>
                                    <button type="button" class="fu-chip-delete"
                                            data-doc-id="{{ $doc->id }}" title="Remove document">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
 
                        {{-- New document upload --}}
                        <div class="col-md-12">
                            <label class="fu-doc-section-label">
                                <i class="fas fa-cloud-upload-alt"></i> Add More Documents
                            </label>
                            <div class="fu-doc-upload-area">
                                <div class="fu-dropzone" id="dropzone-{{ $rowIdx }}">
                                    <i class="fas fa-cloud-upload-alt fu-drop-icon"></i>
                                    <p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span></p>
                                    <p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>
                                    {{--
                                        IMPORTANT: name="documents[]" — generic array.
                                        JS will re-index to documents[N][] on submit
                                        so it matches the sequential PHP loop index.
                                    --}}
                                    <input type="file" name="documents[]" class="fu-file-input" multiple
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
<div class="fu-sticky-bar">
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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <link rel="stylesheet" href="{{ asset('style/customerFollowup.css') }}">
@endpush

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
     <script>
        window.FollowUpConfig = {
            csrfToken:    '{{ csrf_token() }}',
            quotationId:  '{{ $quotation_id ?? "" }}',
            opportunityId:  '{{ $opportunity_id ?? "" }}',
            initialCount: {{ $ofollowups->count() + 1 }},
            deleteDocUrl: '{{ url("customer/followup-document") }}',
        };
    </script>
    <script src="{{ asset('js/followup.js') }}">
    </script>
@stop