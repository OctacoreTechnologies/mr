/**
 * followup-edit.js  —  public/js/followup-edit.js
 *
 * KEY BUG FIX (document upload not saving on existing rows):
 * ──────────────────────────────────────────────────────────
 * Problem: Form ke har row me file input ka name "documents[]" tha.
 *          PHP controller loop me $index 0,1,2,3... sequential hota hai.
 *          Par pehle ke code me nextIdx se dynamic names (documents[4][])
 *          ban rahe the jo PHP ke sequential index se match nahi karte the.
 *
 * Fix:     Form submit hone se PEHLE, JS sabhi .followup-row ko
 *          DOM order me loop karta hai aur har row ke file input ka
 *          name "documents[N][]" set karta hai jahan N = 0,1,2,...
 *          Yeh PHP controller ke foreach index se exactly match karta hai.
 */

document.addEventListener('DOMContentLoaded', function () {

     /* ── JS: header click = expand/collapse ── */

    (function () {
    var header   = document.getElementById('fuHistHeader');
    var body     = document.getElementById('fuHistBody');
    var chevron  = document.getElementById('fuHistChevron');
    var hint     = document.getElementById('fuHistHint');
    var open     = false;
 
    header.addEventListener('click', function () {
        open = !open;
        body.style.display    = open ? 'block' : 'none';
        chevron.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
        hint.textContent      = open ? 'Click to collapse' : 'Click to expand';
    });
  })();


    /* ════════════════════════════════════════
    |  1.  CONFIG  (Blade bridge)
    ════════════════════════════════════════ */
    const CFG        = window.FollowUpConfig || {};
    const CSRF       = CFG.csrfToken    || '';
    const QUOT_ID    = CFG.quotationId  || '';
    const DEL_URL    = CFG.deleteDocUrl || '/customer/followup-document';
    let   nextIdx    = CFG.initialCount || 1;   // only used for unique quill/dropzone IDs

    /* ════════════════════════════════════════
    |  2.  QUILL TOOLBAR
    ════════════════════════════════════════ */
    const TOOLBAR = [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
        [{ indent: '-1' }, { indent: '+1' }],
        ['link'],
        [{ color: [] }, { background: [] }],
        ['clean'],
    ];

    /**
     * Init Quill on a row.
     * Reads existing HTML from the sibling hidden textarea's data-content attr.
     * Syncs back on every text-change.
     */
    function initQuill(uid) {
        const el = document.getElementById('quill-' + uid);
        if (!el || el.__quill) return;          // skip if already initialised

        const wrap = el.closest('.fu-editor-wrap');
        const ta   = wrap && wrap.querySelector('.fu-notes-hidden');
        if (!ta) return;

        const q = new Quill(el, {
            theme: 'snow',
            modules: { toolbar: TOOLBAR },
            placeholder: 'Enter discussion points, action items, key decisions...',
        });

        // Load existing content
        const raw = ta.dataset.content ? decodeEntities(ta.dataset.content) : '';
        if (raw) q.clipboard.dangerouslyPasteHTML(raw);
        ta.value = raw;

        // Keep textarea in sync
        q.on('text-change', function () { ta.value = q.getSemanticHTML(); });

        el.__quill = q;    // mark as initialised
        return q;
    }

    function decodeEntities(str) {
        const t = document.createElement('textarea');
        t.innerHTML = str;
        return t.value;
    }

    // Init all editors already in DOM
    document.querySelectorAll('.fu-quill-editor').forEach(function (el) {
        initQuill(el.id.replace('quill-', ''));
    });

    /* ════════════════════════════════════════
    |  3.  FILE HELPERS
    ════════════════════════════════════════ */
    const iconMap = {
        pdf: 'fas fa-file-pdf text-danger',
        xls: 'fas fa-file-excel text-success', xlsx: 'fas fa-file-excel text-success',
        csv: 'fas fa-file-csv text-success',
        doc: 'fas fa-file-word text-primary',  docx: 'fas fa-file-word text-primary',
        jpg: 'fas fa-file-image text-warning', jpeg: 'fas fa-file-image text-warning',
        png: 'fas fa-file-image text-warning', gif: 'fas fa-file-image text-warning',
        webp: 'fas fa-file-image text-warning', svg: 'fas fa-file-image text-warning',
        zip: 'fas fa-file-archive text-secondary', rar: 'fas fa-file-archive text-secondary',
    };
    function icon(name) { return iconMap[name.split('.').pop().toLowerCase()] || 'fas fa-file text-muted'; }
    function kb(b) { return b >= 1048576 ? (b/1048576).toFixed(2)+' MB' : (b/1024).toFixed(1)+' KB'; }
    function trunc(s, n) { n=n||25; return s.length>n ? s.slice(0,n-3)+'...' : s; }

    /* ════════════════════════════════════════
    |  4.  DROPZONE
    ════════════════════════════════════════ */
    function initDropzone(uid) {
        const zone   = document.getElementById('dropzone-' + uid);
        const listEl = document.getElementById('fileList-' + uid);
        if (!zone || !listEl || zone.__dzInit) return;
        zone.__dzInit = true;

        const inp   = zone.querySelector('.fu-file-input');
        let   store = [];

        function render() {
            listEl.innerHTML = '';
            store.forEach(function (f, i) {
                const d = document.createElement('div');
                d.className = 'fu-file-item';
                d.innerHTML =
                    '<i class="'+icon(f.name)+'"></i>' +
                    '<span class="fu-file-item-name" title="'+f.name+'">'+trunc(f.name)+'</span>' +
                    '<span class="fu-file-item-size">'+kb(f.size)+'</span>' +
                    '<button type="button" class="fu-file-item-remove" data-i="'+i+'" title="Remove">'+
                        '<i class="fas fa-times"></i></button>';
                listEl.appendChild(d);
            });
            const dt = new DataTransfer();
            store.forEach(function (f) { dt.items.add(f); });
            inp.files = dt.files;
        }

        listEl.addEventListener('click', function (e) {
            const b = e.target.closest('.fu-file-item-remove');
            if (b) { store.splice(+b.dataset.i, 1); render(); }
        });
        inp.addEventListener('change', function () {
            Array.from(this.files).forEach(function (f) { store.push(f); });
            render();
        });
        zone.addEventListener('dragover',  function (e) { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', function ()  { zone.classList.remove('drag-over'); });
        zone.addEventListener('drop', function (e) {
            e.preventDefault(); zone.classList.remove('drag-over');
            Array.from(e.dataTransfer.files).forEach(function (f) { store.push(f); });
            render();
        });
    }

    // Init all dropzones in DOM
    document.querySelectorAll('.fu-dropzone').forEach(function (zone) {
        initDropzone(zone.id.replace('dropzone-', ''));
    });

    /* ════════════════════════════════════════
    |  5.  FORM SUBMIT
    |
    |  TWO things happen before submit:
    |  a) Sync all Quill editors → hidden textareas
    |  b) Re-index file inputs so documents[N][]
    |     matches the PHP sequential loop index N
    ════════════════════════════════════════ */
    const form = document.getElementById('followupForm');

    if (form) {
        form.addEventListener('submit', function () {

            // a) Quill sync (safety net)
            document.querySelectorAll('.fu-quill-editor').forEach(function (el) {
                const q  = el.__quill;
                const ta = el.closest('.fu-editor-wrap') &&
                           el.closest('.fu-editor-wrap').querySelector('.fu-notes-hidden');
                if (q && ta) ta.value = q.getSemanticHTML();
            });

            // b) Re-index file inputs
            //    Loop all rows in DOM order (index 0, 1, 2 ...)
            //    Set each row's file input name to documents[N][]
            //    This matches PHP's: foreach($validated['follow_up_date'] as $N => $date)
            const rows = document.querySelectorAll('#followup-container .followup-row');
            rows.forEach(function (row, seqIndex) {
                const fileInput = row.querySelector('.fu-file-input');
                if (fileInput) {
                    fileInput.name = 'documents[' + seqIndex + '][]';
                }
            });
        });
    }

    /* ════════════════════════════════════════
    |  6.  DELETE EXISTING DOCUMENT  (AJAX)
    ════════════════════════════════════════ */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.fu-chip-delete');
        if (!btn) return;

        const docId = btn.dataset.docId;
        const chip  = document.getElementById('docChip-' + docId);
        if (!chip) return;
        if (!confirm('Remove this document?')) return;

        chip.classList.add('removing');

        fetch(DEL_URL + '/' + docId, {
            method:  'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.status) {
                chip.remove();
            } else {
                chip.classList.remove('removing');
                alert('Failed to delete. Please try again.');
            }
        })
        .catch(function () {
            chip.classList.remove('removing');
            alert('Network error. Please check connection.');
        });
    });

    /* ════════════════════════════════════════
    |  7.  HISTORY TOGGLE (outer)
    ════════════════════════════════════════ */
    const hToggle  = document.getElementById('historyToggle');
    const hBody    = document.getElementById('historyBody');
    const hChevron = document.getElementById('historyChevron');
    const hHint    = document.getElementById('toggleHint');

    if (hToggle && hBody) {
        hToggle.addEventListener('click', function () {
            const open = hBody.style.display !== 'none';
            hBody.style.display = open ? 'none' : 'block';
            if (hChevron) hChevron.classList.toggle('open', !open);
            if (hHint)    hHint.textContent = open ? 'Click to expand' : 'Click to collapse';
        });
    }

    /* ════════════════════════════════════════
    |  8.  HISTORY ITEM EXPAND / COLLAPSE
    ════════════════════════════════════════ */
    document.addEventListener('click', function (e) {
        // Both the summary row AND the chevron button trigger expand
        const btn     = e.target.closest('.fu-hist-expand-btn');
        const summary = e.target.closest('.fu-history-summary');
        if (!btn && !summary) return;

        // Prevent double-fire when clicking the button inside the summary
        if (summary && e.target.closest('.fu-hist-expand-btn')) {
            // let btn handler deal with it
            if (!btn) return;
        }

        const hi     = (btn || summary).dataset.hi;
        const detail = document.getElementById('histDetail-' + hi);
        const chev   = document.getElementById('histChev-' + hi);
        if (!detail) return;

        const isOpen = detail.style.display !== 'none';
        detail.style.display = isOpen ? 'none' : 'block';
        if (chev) chev.classList.toggle('open', !isOpen);
    });

    /* ════════════════════════════════════════
    |  9.  REMOVE ROW
    ════════════════════════════════════════ */
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

    /* ════════════════════════════════════════
    |  10. ADD NEW ROW
    ════════════════════════════════════════ */
    const addBtn = document.getElementById('addRowBtn');

    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const uid = nextIdx;   // unique ID for quill / dropzone elements

            const html =
                '<div class="followup-row followup-row--new" data-index="'+uid+'">' +
                    '<div class="followup-row-header">' +
                        '<span class="followup-row-label"><i class="fas fa-plus-circle"></i> New Entry</span>' +
                        '<button type="button" class="crm-remove-btn remove-followup">' +
                            '<i class="fas fa-trash"></i> Remove</button>' +
                    '</div>' +
                    '<input type="hidden" name="follow_up_id[]" value="">' +
                    '<input type="hidden" name="quotation_id" value="'+QUOT_ID+'">' +
                    '<div class="row">' +
                        '<div class="col-md-6">' +
                            '<div class="form-group mb-3"><label>Follow-Up Date</label>' +
                            '<input type="text" name="follow_up_date[]" class="form-control fu-date-new"></div>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                            '<div class="form-group mb-3"><label>Next Follow-Up Date</label>' +
                            '<input type="text" name="next_follow_up_date[]" class="form-control fu-date-new"></div>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                            '<div class="fu-editor-wrap mb-3">' +
                                '<label class="fu-editor-label">' +
                                    '<i class="fas fa-align-left"></i> Notes' +
                                    '<span class="fu-editor-hint">Bullets, numbering, bold — format discussion points</span>' +
                                '</label>' +
                                '<textarea name="notes[]" class="fu-notes-hidden" style="display:none;"></textarea>' +
                                '<div class="fu-quill-editor" id="quill-'+uid+'"></div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                            '<div class="fu-doc-upload-area">' +
                                '<div class="fu-dropzone" id="dropzone-'+uid+'">' +
                                    '<i class="fas fa-cloud-upload-alt fu-drop-icon"></i>' +
                                    '<p class="fu-drop-text">Drag & drop or <span class="fu-drop-link">browse</span></p>' +
                                    '<p class="fu-drop-hint">PDF, Excel, Word, Images, ZIP — max 20 MB each</p>' +
                                    // name will be corrected to documents[N][] on submit
                                    '<input type="file" name="documents[]" class="fu-file-input" multiple ' +
                                        'accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.svg,.zip,.rar">' +
                                '</div>' +
                                '<div class="fu-file-list" id="fileList-'+uid+'"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

            container.insertAdjacentHTML('afterbegin', html);

            // Flatpickr on new date inputs
            container.querySelectorAll('.fu-date-new').forEach(function (el) {
                flatpickr(el, { enableTime: true, dateFormat: 'Y-m-d h:i K', time_24hr: false });
                el.classList.remove('fu-date-new');
            });

            initQuill(uid);
            initDropzone(uid);
            nextIdx++;
            updateCount();
        });
    }

    /* ════════════════════════════════════════
    |  11. ENTRY COUNT
    ════════════════════════════════════════ */
    function updateCount() {
        if (!container) return;
        const n  = container.querySelectorAll('.followup-row').length;
        const lbl = n === 1 ? ' entry' : ' entries';
        const ce  = document.getElementById('entryCount');
        const si  = document.getElementById('stickyInfo');
        if (ce) ce.textContent = n + lbl;
        if (si) si.textContent = n + lbl + ' to save';
    }
    updateCount();

    /* ════════════════════════════════════════
    |  12. FLATPICKR  (existing date fields)
    ════════════════════════════════════════ */
    flatpickr('.date-time', {
        enableTime: true,
        dateFormat: 'Y-m-d h:i K',
        time_24hr:  false,
    });

});