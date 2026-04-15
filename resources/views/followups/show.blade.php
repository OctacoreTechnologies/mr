@extends('layouts.app')

@section('title', "Follow-Ups — " . $customer->company_name)

@section('content_header')
<div class="crm-page-header">
    <h1>
        <i class="fas fa-comments"></i>
        Follow-Up History
    </h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')

<x-alert-components class="my-3" />

{{-- ══ CUSTOMER PROFILE BANNER ══ --}}
<div class="fu-profile-banner mb-4">
    <div class="fu-profile-avatar">
        {{ strtoupper(substr($customer->company_name ?? $customer->name, 0, 2)) }}
    </div>
    <div class="fu-profile-info">
        <h2 class="fu-profile-name">{{ $customer->company_name ?? $customer->name }}</h2>
        <div class="fu-profile-meta">
            @if($customer->contact_person_1_email)
                <span class="fu-meta-item">
                    <i class="fas fa-envelope"></i>
                    {{ $customer->contact_person_1_email }}
                </span>
            @endif
            @if($customer->contact_no)
                <span class="fu-meta-item">
                    <i class="fas fa-phone"></i>
                    {{ $customer->contact_no }}
                </span>
            @endif
        </div>
    </div>
    <div class="fu-profile-stats">
        <div class="fu-stat">
            <span class="fu-stat-value">{{ $followups->count() }}</span>
            <span class="fu-stat-label">Total Follow-Ups</span>
        </div>
        @php
            $latestNext = $followups->whereNotNull('next_follow_up_date')->sortByDesc('next_follow_up_date')->first();
        @endphp
        @if($latestNext)
            <div class="fu-stat">
                <span class="fu-stat-value fu-stat-date">
                    {{ \Carbon\Carbon::parse($latestNext->next_follow_up_date)->format('d M') }}
                </span>
                <span class="fu-stat-label">Next Follow-Up</span>
            </div>
        @endif
        <div class="fu-stat">
            <span class="fu-stat-value">
                {{ $followups->sum(fn($f) => $f->documents->count()) }}
            </span>
            <span class="fu-stat-label">Documents</span>
        </div>
    </div>
</div>

{{-- ══ FOLLOW-UP TIMELINE ══ --}}
@if($followups->isEmpty())
    <div class="fu-empty-state">
        <div class="fu-empty-icon"><i class="fas fa-calendar-times"></i></div>
        <h4>No Follow-Ups Yet</h4>
        <p>No follow-up records have been added for this customer.</p>
    </div>
@else
    <div class="fu-timeline-wrapper">
        <div class="fu-timeline-line"></div>

        @foreach ($followups as $index => $followup)
            @php
                $isLatest = $index === 0;
                $isPast = \Carbon\Carbon::parse($followup->next_follow_up_date)->isPast();
                $isToday = \Carbon\Carbon::parse($followup->next_follow_up_date)->isToday();
                $docCount = $followup->documents->count();

                // Strip HTML tags for preview in collapsed view
                $plainNotes = strip_tags($followup->notes ?? '');
                $notesIsLong = mb_strlen($plainNotes) > 200;
            @endphp

            <div class="fu-timeline-item {{ $isLatest ? 'fu-timeline-item--latest' : '' }}">

                <div class="fu-timeline-node {{ $isLatest ? 'fu-node--active' : '' }}">
                    <span class="fu-node-number">{{ $followups->count() - $index }}</span>
                </div>

                <div class="fu-timeline-card">

                    {{-- ── Card Header ── --}}
                    <div class="fu-card-header">
                        <div class="fu-card-dates">
                            <span class="fu-date-pill fu-date-pill--followup">
                                <i class="fas fa-calendar-day"></i>
                                {{ \Carbon\Carbon::parse($followup->follow_up_date)->format('d M Y, h:i A') }}
                            </span>
                            <i class="fas fa-long-arrow-alt-right fu-arrow-sep"></i>
                            <span
                                class="fu-date-pill {{ $isToday ? 'fu-date-pill--today' : ($isPast ? 'fu-date-pill--past' : 'fu-date-pill--next') }}">
                                <i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($followup->next_follow_up_date)->format('d M Y, h:i A') }}
                                @if($isToday)
                                    <span class="fu-today-tag">Today</span>
                                @endif
                            </span>
                        </div>
                        <div class="fu-card-badges">
                            @if($docCount)
                                <span class="fu-badge fu-badge--doc">
                                    <i class="fas fa-paperclip"></i> {{ $docCount }} {{ Str::plural('file', $docCount) }}
                                </span>
                            @endif
                            @if($isToday)
                                <span class="fu-badge fu-badge--today">Due Today</span>
                            @elseif($isPast)
                                <span class="fu-badge fu-badge--past">Completed</span>
                            @else
                                <span class="fu-badge fu-badge--upcoming">Upcoming</span>
                            @endif
                        </div>
                    </div>

                    {{-- ── Notes (Rich HTML from Quill) ── --}}
                    <div class="fu-notes-body">
                        <div class="fu-notes-label">
                            <i class="fas fa-file-alt"></i> Discussion Notes
                        </div>

                        @if($followup->notes)
                            <div class="fu-rich-content fu-notes-short" id="notesShort-{{ $index }}">
                                {{--
                                Show truncated PLAIN text for collapsed view.
                                If user wants full formatted view they expand.
                                --}}
                                @if($notesIsLong)
                                    <p class="fu-notes-plain-preview">
                                        {{ mb_substr($plainNotes, 0, 200) }}<span class="fu-notes-ellipsis">…</span>
                                    </p>
                                    <button class="fu-expand-btn" data-idx="{{ $index }}">
                                        <i class="fas fa-expand-alt"></i> Show formatted notes
                                    </button>
                                @else
                                    {{-- Short notes: render formatted HTML directly --}}
                                    {!! $followup->notes !!}
                                @endif
                            </div>

                            @if($notesIsLong)
                                {{-- Full formatted Quill HTML --}}
                                <div class="fu-rich-content fu-notes-full" id="notesFull-{{ $index }}" style="display:none;">
                                    {!! $followup->notes !!}
                                    <button class="fu-expand-btn fu-expand-btn--collapse" data-idx="{{ $index }}">
                                        <i class="fas fa-compress-alt"></i> Collapse
                                    </button>
                                </div>
                            @endif
                        @else
                            <p class="fu-notes-empty">No notes added for this follow-up.</p>
                        @endif
                    </div>

                    {{-- ── Documents ── --}}
                    @if($docCount)
                        <div class="fu-docs-section">
                            <div class="fu-docs-label">
                                <i class="fas fa-folder-open"></i> Attachments
                            </div>
                            <div class="fu-docs-grid">
                                @foreach($followup->documents as $doc)
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="fu-doc-tile"
                                        title="{{ $doc->original_name }}">
                                        @if($doc->is_image)
                                            <div class="fu-doc-thumb">
                                                <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->original_name }}"
                                                    loading="lazy">
                                            </div>
                                        @else
                                            <div class="fu-doc-icon-wrap">
                                                <i class="{{ $doc->icon_class }}"></i>
                                            </div>
                                        @endif
                                        <div class="fu-doc-tile-info">
                                            <span class="fu-doc-tile-name">{{ Str::limit($doc->original_name, 22, '…') }}</span>
                                            <span class="fu-doc-tile-meta">{{ $doc->human_size }} ·
                                                {{ strtoupper($doc->file_type) }}</span>
                                        </div>
                                        <div class="fu-doc-tile-hover">
                                            <i class="fas fa-download"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="fu-card-footer">
                        <span class="fu-footer-meta">
                            <i class="fas fa-clock"></i>
                            Added {{ \Carbon\Carbon::parse($followup->created_at)->diffForHumans() }}
                        </span>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif

@stop

@push('css')
    {{-- Quill Snow for rendering formatted notes --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/common.css') }}">
    <link rel="stylesheet" href="{{ asset('style/commonindex.css') }}">
    <style>
        /* ── Page header ── */
        .crm-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── Profile banner ── */
        .fu-profile-banner {
            display: flex;
            align-items: center;
            gap: 20px;
            background: var(--crm-card-bg, #fff);
            border: 1.5px solid var(--crm-border, #e5e7eb);
            border-radius: var(--crm-radius, 10px);
            padding: 22px 28px;
            box-shadow: 0 2px 12px rgba(37, 99, 235, .07);
        }

        .fu-profile-avatar {
            flex-shrink: 0;
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--crm-primary, #2563eb), #3b82f6);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
        }

        .fu-profile-info {
            flex: 1;
            min-width: 0;
        }

        .fu-profile-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--crm-text, #111827);
            margin: 0 0 6px;
        }

        .fu-profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .fu-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .82rem;
            color: #6b7280;
        }

        .fu-meta-item i {
            color: var(--crm-primary, #2563eb);
            font-size: .76rem;
        }

        .fu-profile-stats {
            display: flex;
            gap: 24px;
            flex-shrink: 0;
        }

        .fu-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .fu-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--crm-primary, #2563eb);
            line-height: 1;
        }

        .fu-stat-date {
            font-size: 1.1rem;
        }

        .fu-stat-label {
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
        }

        /* ── Empty state ── */
        .fu-empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border: 1.5px dashed #e5e7eb;
            border-radius: 10px;
        }

        .fu-empty-icon {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 14px;
        }

        .fu-empty-state h4 {
            color: #374151;
            font-weight: 700;
        }

        .fu-empty-state p {
            color: #9ca3af;
            font-size: .88rem;
        }

        /* ── Timeline ── */
        .fu-timeline-wrapper {
            position: relative;
            padding-left: 44px;
        }

        .fu-timeline-line {
            position: absolute;
            left: 17px;
            top: 12px;
            bottom: 12px;
            width: 2px;
            background: linear-gradient(to bottom, var(--crm-primary, #2563eb) 0%, #e2e8f0 100%);
            border-radius: 2px;
        }

        .fu-timeline-item {
            position: relative;
            margin-bottom: 20px;
            display: flex;
        }

        .fu-timeline-node {
            position: absolute;
            left: -36px;
            top: 14px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #fff;
            border: 2.5px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 800;
            color: #94a3b8;
            z-index: 1;
        }

        .fu-node--active {
            border-color: var(--crm-primary, #2563eb);
            color: var(--crm-primary, #2563eb);
            background: #eff6ff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .fu-timeline-card {
            flex: 1;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
        }

        .fu-timeline-card:hover {
            border-color: var(--crm-primary, #2563eb);
            box-shadow: 0 4px 18px rgba(37, 99, 235, .10);
        }

        .fu-timeline-item--latest .fu-timeline-card {
            border-color: var(--crm-primary, #2563eb);
            box-shadow: 0 4px 18px rgba(37, 99, 235, .10);
        }

        /* ── Card header ── */
        .fu-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            padding: 13px 16px 10px;
            border-bottom: 1px solid #f1f5f9;
            background: #f9fafb;
        }

        .fu-card-dates {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .fu-date-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .76rem;
            font-weight: 600;
        }

        .fu-date-pill--followup {
            background: #f1f5f9;
            color: #475569;
        }

        .fu-date-pill--next {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .fu-date-pill--today {
            background: #fef3c7;
            color: #d97706;
            animation: fu-pulse 2s infinite;
        }

        .fu-date-pill--past {
            background: #f1f5f9;
            color: #94a3b8;
        }

        @keyframes fu-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(217, 119, 6, .3);
            }

            50% {
                box-shadow: 0 0 0 5px rgba(217, 119, 6, .0);
            }
        }

        .fu-today-tag {
            background: #d97706;
            color: #fff;
            font-size: .62rem;
            font-weight: 800;
            padding: 1px 5px;
            border-radius: 4px;
        }

        .fu-arrow-sep {
            color: #cbd5e1;
            font-size: .82rem;
        }

        .fu-card-badges {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fu-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: .71rem;
            font-weight: 700;
        }

        .fu-badge--doc {
            background: #ede9fe;
            color: #7c3aed;
        }

        .fu-badge--past {
            background: #dcfce7;
            color: #16a34a;
        }

        .fu-badge--today {
            background: #fef3c7;
            color: #d97706;
        }

        .fu-badge--upcoming {
            background: #dbeafe;
            color: #1d4ed8;
        }

        /* ══ RICH NOTES RENDERING ══ */
        .fu-notes-body {
            padding: 14px 16px 10px;
        }

        .fu-notes-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        /* The actual Quill-generated HTML rendered as report */
        .fu-rich-content {
            font-size: .875rem;
            line-height: 1.7;
            color: #1e293b;
        }

        .fu-rich-content p {
            margin-bottom: 6px;
        }

        .fu-rich-content ul,
        .fu-rich-content ol {
            padding-left: 1.4em;
            margin-bottom: 8px;
        }

        .fu-rich-content li {
            margin-bottom: 3px;
        }

        .fu-rich-content strong {
            font-weight: 700;
        }

        .fu-rich-content em {
            font-style: italic;
        }

        .fu-rich-content u {
            text-decoration: underline;
        }

        .fu-rich-content s {
            text-decoration: line-through;
            color: #94a3b8;
        }

        .fu-rich-content h1 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .fu-rich-content h2 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .fu-rich-content h3 {
            font-size: .9rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .fu-rich-content a {
            color: var(--crm-primary, #2563eb);
            text-decoration: underline;
        }

        .fu-rich-content a:hover {
            opacity: .8;
        }

        /* Quill indentation classes */
        .fu-rich-content .ql-indent-1 {
            padding-left: 2em;
        }

        .fu-rich-content .ql-indent-2 {
            padding-left: 4em;
        }

        .fu-rich-content .ql-indent-3 {
            padding-left: 6em;
        }

        /* Checklist items (Quill task lists) */
        .fu-rich-content li[data-list="checked"]::before {
            content: "✅ ";
        }

        .fu-rich-content li[data-list="unchecked"]::before {
            content: "☐ ";
        }

        .fu-notes-plain-preview {
            color: #374151;
            font-size: .875rem;
            line-height: 1.65;
            margin: 0 0 8px;
        }

        .fu-notes-ellipsis {
            color: #9ca3af;
        }

        .fu-notes-empty {
            color: #9ca3af;
            font-size: .84rem;
            font-style: italic;
            margin: 0;
        }

        /* Expand / collapse button */
        .fu-expand-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: none;
            border: 1px solid #e2e8f0;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: .76rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--crm-primary, #2563eb);
            transition: background .15s, border-color .15s;
            margin-top: 6px;
        }

        .fu-expand-btn:hover {
            background: #eff6ff;
            border-color: var(--crm-primary, #2563eb);
        }

        /* ── Documents ── */
        .fu-docs-section {
            padding: 12px 16px 14px;
            border-top: 1px solid #f1f5f9;
            background: #fafbfd;
        }

        .fu-docs-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .fu-docs-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .fu-doc-tile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            max-width: 200px;
            transition: border-color .2s, box-shadow .2s, transform .15s;
            overflow: hidden;
        }

        .fu-doc-tile:hover {
            border-color: var(--crm-primary, #2563eb);
            box-shadow: 0 3px 12px rgba(37, 99, 235, .13);
            transform: translateY(-1px);
        }

        .fu-doc-thumb {
            width: 36px;
            height: 36px;
            border-radius: 5px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .fu-doc-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fu-doc-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 5px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .fu-doc-tile-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .fu-doc-tile-name {
            font-size: .78rem;
            font-weight: 600;
            color: #1e293b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .fu-doc-tile-meta {
            font-size: .68rem;
            color: #94a3b8;
        }

        .fu-doc-tile-hover {
            position: absolute;
            inset: 0;
            background: rgba(37, 99, 235, .08);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .2s;
            font-size: 1rem;
            color: var(--crm-primary, #2563eb);
        }

        .fu-doc-tile:hover .fu-doc-tile-hover {
            opacity: 1;
        }

        /* ── Card footer ── */
        .fu-card-footer {
            padding: 7px 16px;
            border-top: 1px solid #f1f5f9;
            background: #f9fafb;
        }

        .fu-footer-meta {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .74rem;
            color: #94a3b8;
        }

        /* ── Responsive ── */
        @media (max-width: 767px) {
            .fu-profile-banner {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 16px;
            }

            .fu-profile-stats {
                width: 100%;
                justify-content: space-around;
                padding-top: 12px;
                border-top: 1px solid #e5e7eb;
            }

            .fu-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .fu-card-dates {
                flex-direction: column;
                gap: 4px;
            }

            .fu-arrow-sep {
                display: none;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── Expand / Collapse notes ── */
            document.querySelectorAll('.fu-expand-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const idx = this.dataset.idx;
                    const isCollapse = this.classList.contains('fu-expand-btn--collapse');
                    document.getElementById('notesShort-' + idx).style.display = isCollapse ? 'block' : 'none';
                    document.getElementById('notesFull-' + idx).style.display = isCollapse ? 'none' : 'block';
                });
            });

        });
    </script>
@endpush