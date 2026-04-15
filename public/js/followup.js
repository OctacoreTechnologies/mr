/**
 * followup-edit.js
 * Place at: public/js/followup-edit.js
 *
 * Features:
 *  - Quill rich text editor (bullets, numbering, bold, italic, links)
 *  - Drag & drop file upload with live preview
 *  - AJAX document delete
 *  - Dynamic add/remove rows
 *  - Flatpickr date-time pickers
 *
 * NOTE: Zero Blade {{ }} syntax here.
 * All PHP values come from window.FollowUpConfig (defined inline in blade).
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ══════════════════════════════════════════
    |  1. CONFIG
    ══════════════════════════════════════════ */
    const CONFIG        = window.FollowUpConfig || {};
    const CSRF_TOKEN    = CONFIG.csrfToken    || '';
    const QUOTATION_ID  = CONFIG.quotationId  || '';
    const DELETE_URL    = CONFIG.deleteDocUrl || '/customer/followup-document';
    let   nextIdx       = CONFIG.initialCount || 1;

    /* ══════════════════════════════════════════
    |  2. QUILL TOOLBAR CONFIG
    |  Reused for every editor instance
    ══════════════════════════════════════════ */
    const QUILL_TOOLBAR = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        ['link'],
        [{ 'color': [] }, { 'background': [] }],
        ['clean'],
    ];

    /**
     * Initialise a Quill editor for a given row index.
     * Reads existing HTML from the sibling hidden textarea's data-content.
     * On any change, syncs HTML back to that hidden textarea.
     *
     * @param {number|string} idx
     */
    function initQuill(idx) {
        const editorEl = document.getElementById('quill-' + idx);
        if (!editorEl) return;

        // Find the hidden textarea in the same .fu-editor-wrap
        const wrap      = editorEl.closest('.fu-editor-wrap');
        const hiddenTA  = wrap ? wrap.querySelector('.fu-notes-hidden') : null;
        if (!hiddenTA) return;

        // Read pre-existing HTML content (for existing rows)
        const existingHtml = hiddenTA.dataset.content
            ? decodeHTMLEntities(hiddenTA.dataset.content)
            : '';

        const quill = new Quill(editorEl, {
            theme:       'snow',
            modules:     { toolbar: QUILL_TOOLBAR },
            placeholder: 'Enter discussion points, action items, key decisions...',
        });

        // Set existing content
        if (existingHtml) {
            quill.clipboard.dangerouslyPasteHTML(existingHtml);
        }

        // Sync editor HTML → hidden textarea on every change
        quill.on('text-change', function () {
            hiddenTA.value = quill.getSemanticHTML();
        });

        // Also sync once on init so the value is ready even without editing
        hiddenTA.value = existingHtml || '';

        return quill;
    }

    /**
     * Decode HTML entities from a string (e.g. &lt; → <).
     * Used to safely restore htmlspecialchars-encoded PHP output.
     * @param {string} str
     * @returns {string}
     */
    function decodeHTMLEntities(str) {
        const txt = document.createElement('textarea');
        txt.innerHTML = str;
        return txt.value;
    }

    /* Init all Quill editors already in the DOM */
    document.querySelectorAll('.fu-quill-editor').forEach(function (el) {
        const idx = el.id.replace('quill-', '');
        initQuill(idx);
    });

    /* ══════════════════════════════════════════
    |  3. FILE-TYPE → ICON MAP
    ══════════════════════════════════════════ */
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
        if (bytes >= 1_048_576) return (bytes / 1_048_576).toFixed(2) + ' MB';
        return (bytes / 1024).toFixed(1) + ' KB';
    }

    function truncate(str, max) {
        max = max || 25;
        return str.length > max ? str.slice(0, max - 3) + '...' : str;
    }

    /* ══════════════════════════════════════════
    |  4. DROPZONE
    ══════════════════════════════════════════ */
    function initDropzone(idx) {
        const zone   = document.getElementById('dropzone-' + idx);
        const listEl = document.getElementById('fileList-' + idx);
        if (!zone || !listEl) return;

        const fileInput = zone.querySelector('.fu-file-input');
        let   fileStore = [];

        function renderList() {
            listEl.innerHTML = '';
            fileStore.forEach(function (file, i) {
                const item = document.createElement('div');
                item.className = 'fu-file-item';
                item.innerHTML =
                    '<i class="' + getIcon(file.name) + '"></i>' +
                    '<span class="fu-file-item-name" title="' + file.name + '">' + truncate(file.name) + '</span>' +
                    '<span class="fu-file-item-size">' + humanSize(file.size) + '</span>' +
                    '<button type="button" class="fu-file-item-remove" data-i="' + i + '" title="Remove">' +
                        '<i class="fas fa-times"></i>' +
                    '</button>';
                listEl.appendChild(item);
            });
            const dt = new DataTransfer();
            fileStore.forEach(function (f) { dt.items.add(f); });
            fileInput.files = dt.files;
        }

        listEl.addEventListener('click', function (e) {
            const btn = e.target.closest('.fu-file-item-remove');
            if (btn) {
                fileStore.splice(parseInt(btn.dataset.i, 10), 1);
                renderList();
            }
        });

        fileInput.addEventListener('change', function () {
            Array.from(this.files).forEach(function (f) { fileStore.push(f); });
            renderList();
        });

        zone.addEventListener('dragover',  function (e) { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', function ()  { zone.classList.remove('drag-over'); });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('drag-over');
            Array.from(e.dataTransfer.files).forEach(function (f) { fileStore.push(f); });
            renderList();
        });
    }

    /* Init all dropzones in DOM */
    document.querySelectorAll('.fu-dropzone').forEach(function (zone) {
        const row = zone.closest('[data-index]');
        if (row) initDropzone(parseInt(row.dataset.index, 10));
    });

    /* ══════════════════════════════════════════
    |  5. SYNC QUILL → HIDDEN TEXTAREA before submit
    |  (Safety net: ensures latest content is captured)
    ══════════════════════════════════════════ */
    const form = document.getElementById('followupForm');
    if (form) {
        form.addEventListener('submit', function () {
            // Each Quill editor syncs on text-change already,
            // but if user submits without editing we force-sync here.
            document.querySelectorAll('.fu-quill-editor').forEach(function (el) {
                const qlInstance = Quill.find(el);
                if (!qlInstance) return;
                const wrap     = el.closest('.fu-editor-wrap');
                const hiddenTA = wrap ? wrap.querySelector('.fu-notes-hidden') : null;
                if (hiddenTA) {
                    hiddenTA.value = qlInstance.getSemanticHTML();
                }
            });
        });
    }

    /* ══════════════════════════════════════════
    |  6. DELETE EXISTING DOCUMENT  (AJAX)
    ══════════════════════════════════════════ */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.fu-chip-delete');
        if (!btn) return;

        const docId = btn.dataset.docId;
        const chip  = document.getElementById('docChip-' + docId);
        if (!chip) return;

        if (!confirm('Remove this document?')) return;
        chip.classList.add('removing');

        fetch(DELETE_URL + '/' + docId, {
            method:  'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.status) {
                chip.remove();
            } else {
                chip.classList.remove('removing');
                alert('Failed to delete document. Please try again.');
            }
        })
        .catch(function () {
            chip.classList.remove('removing');
            alert('Network error. Please check your connection.');
        });
    });

    /* ══════════════════════════════════════════
    |  7. HISTORY TOGGLE
    ══════════════════════════════════════════ */
    const toggleEl  = document.getElementById('historyToggle');
    const bodyEl    = document.getElementById('historyBody');
    const chevronEl = document.getElementById('historyChevron');
    const hintEl    = document.getElementById('toggleHint');

    if (toggleEl && bodyEl) {
        toggleEl.addEventListener('click', function () {
            const isOpen = bodyEl.style.display !== 'none';
            bodyEl.style.display = isOpen ? 'none' : 'block';
            if (chevronEl) chevronEl.classList.toggle('open', !isOpen);
            if (hintEl)    hintEl.textContent = isOpen ? 'Click to expand' : 'Click to collapse';
        });
    }

    /* ══════════════════════════════════════════
    |  8. REMOVE ROW
    ══════════════════════════════════════════ */
    const container = document.getElementById('followup-container');

    if (container) {
        container.addEventListener('click', function (e) {
            if (!e.target.closest('.remove-followup')) return;
            if (container.querySelectorAll('.followup-row').length <= 1) {
                alert('At least one follow-up entry is required.');
                return;
            }
            e.target.closest('.followup-row').remove();
            updateCount();
        });
    }

    /* ══════════════════════════════════════════
    |  9. ADD NEW ROW (with Quill + Dropzone)
    ══════════════════════════════════════════ */
    const addRowBtn = document.getElementById('addRowBtn');

    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {

            const html =
                '<div class="followup-row followup-row--new" data-index="' + nextIdx + '">' +
                    '<div class="followup-row-header">' +
                        '<span class="followup-row-label">' +
                            '<i class="fas fa-plus-circle"></i> New Entry' +
                        '</span>' +
                        '<button type="button" class="crm-remove-btn remove-followup">' +
                            '<i class="fas fa-trash"></i> Remove' +
                        '</button>' +
                    '</div>' +
                    '<input type="hidden" name="follow_up_id[]" value="">' +
                    '<input type="hidden" name="quotation_id" value="' + QUOTATION_ID + '">' +
                    '<div class="row">' +
                        '<div class="col-md-6">' +
                            '<div class="form-group mb-3">' +
                                '<label>Follow-Up Date</label>' +
                                '<input type="text" name="follow_up_date[]" class="form-control fu-date-new">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                            '<div class="form-group mb-3">' +
                                '<label>Next Follow-Up Date</label>' +
                                '<input type="text" name="next_follow_up_date[]" class="form-control fu-date-new">' +
                            '</div>' +
                        '</div>' +

                        /* ── Rich text notes ── */
                        '<div class="col-md-12">' +
                            '<div class="fu-editor-wrap mb-3">' +
                                '<label class="fu-editor-label">' +
                                    '<i class="fas fa-align-left"></i> Notes' +
                                    '<span class="fu-editor-hint">Format with bullets, numbering, bold etc.</span>' +
                                '</label>' +
                                '<textarea name="notes[]" class="fu-notes-hidden" style="display:none;"></textarea>' +
                                '<div class="fu-quill-editor" id="quill-' + nextIdx + '"></div>' +
                            '</div>' +
                        '</div>' +

                        /* ── Dropzone ── */
                        '<div class="col-md-12">' +
                            '<div class="fu-doc-upload-area" data-index="' + nextIdx + '">' +
                                '<div class="fu-dropzone" id="dropzone-' + nextIdx + '">' +
                                    '<i class="fas fa-cloud-upload-alt fu-drop-icon"></i>' +
                                    '<p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span></p>' +
                                    '<p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>' +
                                    '<input type="file"' +
                                        ' name="documents[' + nextIdx + '][]"' +
                                        ' class="fu-file-input" multiple' +
                                        ' accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">' +
                                '</div>' +
                                '<div class="fu-file-list" id="fileList-' + nextIdx + '"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

            container.insertAdjacentHTML('afterbegin', html);

            /* Init flatpickr on new date inputs */
            container.querySelectorAll('.fu-date-new').forEach(function (el) {
                flatpickr(el, { enableTime: true, dateFormat: 'Y-m-d h:i K', time_24hr: false });
                el.classList.remove('fu-date-new');
            });

            /* Init Quill on new editor */
            initQuill(nextIdx);

            /* Init dropzone */
            initDropzone(nextIdx);

            nextIdx++;
            updateCount();
        });
    }

    /* ══════════════════════════════════════════
    |  10. ENTRY COUNT
    ══════════════════════════════════════════ */
    function updateCount() {
        if (!container) return;
        const n       = container.querySelectorAll('.followup-row').length;
        const label   = n === 1 ? ' entry' : ' entries';
        const countEl = document.getElementById('entryCount');
        const stickyEl = document.getElementById('stickyInfo');
        if (countEl)   countEl.textContent  = n + label;
        if (stickyEl)  stickyEl.textContent = n + label + ' to save';
    }
    updateCount();

    /* ══════════════════════════════════════════
    |  11. FLATPICKR  — existing date fields
    ══════════════════════════════════════════ */
    flatpickr('.date-time', {
        enableTime: true,
        dateFormat: 'Y-m-d h:i K',
        time_24hr:  false,
    });

});