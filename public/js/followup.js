
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
   