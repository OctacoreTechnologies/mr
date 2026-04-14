/**
 * followup-edit.js
 * Place this file at: public/js/followup-edit.js
 *
 * Blade variables are passed via window.FollowUpConfig (defined inline in blade).
 * This file contains ZERO {{ }} Blade syntax — pure JavaScript only.
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ══════════════════════════════════════════
    |  CONFIG — read all Blade values from here
    ══════════════════════════════════════════ */
    const CONFIG = window.FollowUpConfig || {};
    const CSRF_TOKEN    = CONFIG.csrfToken    || '';
    const QUOTATION_ID  = CONFIG.quotationId  || '';
    const DELETE_URL    = CONFIG.deleteDocUrl || '/customer/followup-document';
    let   nextIdx       = CONFIG.initialCount || 1;

    /* ══════════════════════════════════════════
    |  FILE TYPE → ICON MAP
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

    /**
     * Get Font Awesome icon class from filename extension.
     * @param {string} filename
     * @returns {string}
     */
    function getIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        return iconMap[ext] || 'fas fa-file text-muted';
    }

    /**
     * Convert bytes to human-readable size string.
     * @param {number} bytes
     * @returns {string}
     */
    function humanSize(bytes) {
        if (bytes >= 1_048_576) return (bytes / 1_048_576).toFixed(2) + ' MB';
        return (bytes / 1024).toFixed(1) + ' KB';
    }

    /**
     * Truncate a string to maxLen chars.
     * @param {string} str
     * @param {number} maxLen
     * @returns {string}
     */
    function truncate(str, maxLen = 25) {
        return str.length > maxLen ? str.slice(0, maxLen - 3) + '...' : str;
    }

    /* ══════════════════════════════════════════
    |  DROPZONE — init for a given row index
    ══════════════════════════════════════════ */

    /**
     * Initialises drag-drop + file preview for a row.
     * @param {number} idx  — the data-index value of the row
     */
    function initDropzone(idx) {
        const zone   = document.getElementById('dropzone-' + idx);
        const listEl = document.getElementById('fileList-' + idx);

        if (!zone || !listEl) return;

        const fileInput = zone.querySelector('.fu-file-input');
        let   fileStore = [];   // accumulated File objects

        /* ── Render queued files ── */
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

            // Sync with the actual <input type="file">
            const dt = new DataTransfer();
            fileStore.forEach(function (f) { dt.items.add(f); });
            fileInput.files = dt.files;
        }

        /* ── Remove a queued file ── */
        listEl.addEventListener('click', function (e) {
            const btn = e.target.closest('.fu-file-item-remove');
            if (btn) {
                fileStore.splice(parseInt(btn.dataset.i, 10), 1);
                renderList();
            }
        });

        /* ── Native file input change ── */
        fileInput.addEventListener('change', function () {
            Array.from(this.files).forEach(function (f) { fileStore.push(f); });
            renderList();
        });

        /* ── Drag & drop ── */
        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('drag-over');
        });
        zone.addEventListener('dragleave', function () {
            zone.classList.remove('drag-over');
        });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('drag-over');
            Array.from(e.dataTransfer.files).forEach(function (f) { fileStore.push(f); });
            renderList();
        });
    }

    /* Init all dropzones already in the DOM */
    document.querySelectorAll('.fu-dropzone').forEach(function (zone) {
        const row = zone.closest('[data-index]');
        if (row) initDropzone(parseInt(row.dataset.index, 10));
    });

    /* ══════════════════════════════════════════
    |  DELETE EXISTING DOCUMENT  (AJAX)
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
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept':       'application/json',
            },
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
            alert('Network error. Please check your connection and try again.');
        });
    });

    /* ══════════════════════════════════════════
    |  HISTORY TOGGLE
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
    |  REMOVE ROW
    ══════════════════════════════════════════ */
    const container = document.getElementById('followup-container');

    if (container) {
        container.addEventListener('click', function (e) {
            if (!e.target.closest('.remove-followup')) return;

            const allRows = container.querySelectorAll('.followup-row');
            if (allRows.length <= 1) {
                alert('At least one follow-up entry is required.');
                return;
            }

            e.target.closest('.followup-row').remove();
            updateCount();
        });
    }

    /* ══════════════════════════════════════════
    |  ADD NEW ROW
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
                        '<div class="col-md-12">' +
                            '<div class="form-group mb-3">' +
                                '<label>Notes</label>' +
                                '<textarea name="notes[]" class="form-control" rows="3" placeholder="Enter follow-up notes..."></textarea>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                            '<div class="fu-doc-upload-area" data-index="' + nextIdx + '">' +
                                '<div class="fu-dropzone" id="dropzone-' + nextIdx + '">' +
                                    '<i class="fas fa-cloud-upload-alt fu-drop-icon"></i>' +
                                    '<p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span></p>' +
                                    '<p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>' +
                                    '<input type="file"' +
                                        ' name="documents[' + nextIdx + '][]"' +
                                        ' class="fu-file-input"' +
                                        ' multiple' +
                                        ' accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">' +
                                '</div>' +
                                '<div class="fu-file-list" id="fileList-' + nextIdx + '"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

            container.insertAdjacentHTML('afterbegin', html);

            /* Init flatpickr on the two new date fields */
            container.querySelectorAll('.fu-date-new').forEach(function (el) {
                flatpickr(el, {
                    enableTime: true,
                    dateFormat: 'Y-m-d h:i K',
                    time_24hr:  false,
                });
                el.classList.remove('fu-date-new'); // prevent double-init
            });

            initDropzone(nextIdx);
            nextIdx++;
            updateCount();
        });
    }

    /* ══════════════════════════════════════════
    |  ENTRY COUNT  (sticky bar + header pill)
    ══════════════════════════════════════════ */
    function updateCount() {
        if (!container) return;
        const n          = container.querySelectorAll('.followup-row').length;
        const label      = n === 1 ? ' entry' : ' entries';
        const countEl    = document.getElementById('entryCount');
        const stickyEl   = document.getElementById('stickyInfo');
        if (countEl)  countEl.textContent  = n + label;
        if (stickyEl) stickyEl.textContent = n + label + ' to save';
    }

    updateCount();

    /* ══════════════════════════════════════════
    |  FLATPICKR — init existing date fields
    ══════════════════════════════════════════ */
    flatpickr('.date-time', {
        enableTime: true,
        dateFormat: 'Y-m-d h:i K',
        time_24hr:  false,
    });

});