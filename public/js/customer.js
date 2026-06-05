(function () {

    const container = document.getElementById('contactPersonsContainer');
    if (!container) return; // Safety: agar page pe container nahi toh exit

    const MAX = 6;
    let personCount = 0;

    // ─────────────────────────────────────────────────────────────────────────
    // Existing data inject karo — create page pe window.EXISTING_PERSONS nahi
    // hoga, edit page pe blade se set hoga (edit.blade.php mein script tag se)
    // ─────────────────────────────────────────────────────────────────────────
    const existingPersons = (window.EXISTING_PERSONS && Array.isArray(window.EXISTING_PERSONS))
        ? window.EXISTING_PERSONS
        : [];

    // ─────────────────────────────────────────────────────────────────────────
    // HTML escape — XSS se bachao
    // ─────────────────────────────────────────────────────────────────────────
    function escHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Single contact/email row banana
    // ─────────────────────────────────────────────────────────────────────────
    function makeEntryRow(fieldName, type, value, isFirst) {
        const isEmail = (type === 'email');
        const btn = isFirst
            ? `<button type="button" class="btn-add-entry" data-type="${type}" title="Add ${type}">
                   <i class="fas fa-plus"></i>
               </button>`
            : `<button type="button" class="btn-remove-entry" title="Remove" onclick="this.parentElement.remove()">
                   <i class="fas fa-minus"></i>
               </button>`;

        return `<div class="multi-row">
                    <input type="${isEmail ? 'email' : 'text'}"
                           name="${fieldName}"
                           class="crm-input"
                           value="${escHtml(value)}"
                           placeholder="${isEmail ? 'email@example.com' : '+91 00000 00000'}">
                    ${btn}
                </div>`;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Multi-entry block (contacts ya emails ka group)
    // ─────────────────────────────────────────────────────────────────────────
    function makeMultiBlock(arrayIdx, type, values) {
        const fieldName = `contact_persons[${arrayIdx}][${type}][]`;
        // Agar values empty/null hai toh ek blank row do
        const items = (Array.isArray(values) && values.length) ? values : [''];
        return items.map((v, i) => makeEntryRow(fieldName, type, v, i === 0)).join('');
    }

    const FILE_ACCEPT = '.jpg,.jpeg,.png,.gif,.svg,.pdf,.xls,.xlsx,.csv,.doc,.docx,.zip,.rar';

    // Existing saved files preview (edit page) — one pill per file, non-removable
    function makeExistingFilePreviews(cards) {
        if (!cards || !cards.length) return '';
        return cards.map(card => `
            <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6b7280;
                        padding:5px 8px;background:#f9fafb;border:1px solid #e5e7eb;
                        border-radius:6px;margin-top:4px">
                <i class="fas fa-paperclip" style="flex-shrink:0"></i>
                <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    ${escHtml(card.split('/').pop())}
                </span>
                <a href="/${escHtml(card)}" target="_blank"
                   style="margin-left:auto;flex-shrink:0;font-size:11px;color:#1D4ED8;text-decoration:none">
                    <i class="fas fa-external-link-alt"></i> View
                </a>
            </div>`).join('');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Full person card banana (blank ya pre-filled)
    // ─────────────────────────────────────────────────────────────────────────
    function createPersonCard(displayNum, arrayIdx, data) {
        data = data || {};

        // DB mein contact field ka naam alag ho sakta hai — dono handle karo
        const contacts = data.contact ?? data.phones ?? [];
        const emails   = data.email   ?? data.emails  ?? [];

        // Multiple saved files (new) or single saved file (old) — both handled
        const savedCards = Array.isArray(data.visiting_cards)
            ? data.visiting_cards
            : (data.visiting_card ? [data.visiting_card] : []);

        const removeBtn = displayNum > 1
            ? `<button type="button" class="btn-remove-person" onclick="removePerson(this)">
                   <i class="fas fa-times"></i> Remove
               </button>`
            : '';

        const div = document.createElement('div');
        div.className = 'person-card';
        div.dataset.person = displayNum;

        div.innerHTML = `
            <div class="person-card-header">
                <span class="person-badge">
                    <i class="fas fa-user" style="font-size:11px"></i>
                    Contact person ${displayNum}
                </span>
                ${removeBtn}
            </div>
            <div class="person-grid">
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Name</label>
                    <input type="text"
                           name="contact_persons[${arrayIdx}][name]"
                           class="crm-input"
                           placeholder="Full name"
                           value="${escHtml(data.name)}">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Designation</label>
                    <input type="text"
                           name="contact_persons[${arrayIdx}][designation]"
                           class="crm-input"
                           placeholder="Job title"
                           value="${escHtml(data.designation)}">
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Contact numbers</label>
                    <div class="multi-entry" data-field="contact" data-idx="${arrayIdx}">
                        ${makeMultiBlock(arrayIdx, 'contact', Array.isArray(contacts) ? contacts : [contacts])}
                    </div>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Email addresses</label>
                    <div class="multi-entry" data-field="email" data-idx="${arrayIdx}">
                        ${makeMultiBlock(arrayIdx, 'email', Array.isArray(emails) ? emails : [emails])}
                    </div>
                </div>
                <div class="crm-field-wrap">
                    <label class="crm-field-label">Upload files (visiting card / documents)</label>
                    <input type="file"
                           name="contact_person_files[${arrayIdx}][]"
                           class="crm-input"
                           accept="${FILE_ACCEPT}"
                           multiple>
                    <span style="font-size:11px;color:#9ca3af;margin-top:3px;display:block">
                        Ctrl+Click to select multiple files
                    </span>
                    ${makeExistingFilePreviews(savedCards)}
                </div>
            </div>`;

        return div;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // + button click → naya row add karo
    // ─────────────────────────────────────────────────────────────────────────
    function addMultiEntry(btn) {
        const type = btn.dataset.type;
        const wrap = btn.closest('.multi-entry');
        const idx  = wrap.dataset.idx;

        const isEmail = (type === 'email');
        const row = document.createElement('div');
        row.className = 'multi-row';
        row.innerHTML = `
            <input type="${isEmail ? 'email' : 'text'}"
                   name="contact_persons[${idx}][${type}][]"
                   class="crm-input"
                   placeholder="${isEmail ? 'email@example.com' : '+91 00000 00000'}">
            <button type="button" class="btn-remove-entry" title="Remove" onclick="this.parentElement.remove()">
                <i class="fas fa-minus"></i>
            </button>`;
        wrap.appendChild(row);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Person remove karo aur reindex karo
    // ─────────────────────────────────────────────────────────────────────────
    function removePerson(btn) {
        btn.closest('.person-card').remove();
        personCount--;
        updateCount();
        reindexPersons();
    }

    function reindexPersons() {
        container.querySelectorAll('.person-card').forEach((card, i) => {
            const num = i + 1;
            card.dataset.person = num;

            card.querySelector('.person-badge').innerHTML =
                `<i class="fas fa-user" style="font-size:11px"></i> Contact person ${num}`;

            card.querySelectorAll('[name]').forEach(el => {
                el.name = el.name
                    .replace(/contact_persons\[\d+\]/, `contact_persons[${i}]`)
                    .replace(/contact_person_files\[\d+\]/, `contact_person_files[${i}]`);
            });

            card.querySelectorAll('.btn-add-entry').forEach(b => b.dataset.idx = i);
            card.querySelectorAll('.multi-entry').forEach(m => m.dataset.idx  = i);
        });
    }

    function updateCount() {
        const el = document.getElementById('personCount');
        if (el) el.textContent = personCount;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Initial render — edit: existing data, create: 1 blank card
    // ─────────────────────────────────────────────────────────────────────────
    function renderInitial() {
        container.innerHTML = '';

        if (existingPersons.length > 0) {
            existingPersons.forEach((person, i) => {
                container.appendChild(createPersonCard(i + 1, i, person));
            });
            personCount = existingPersons.length;
        } else {
            container.appendChild(createPersonCard(1, 0, {}));
            personCount = 1;
        }

        updateCount();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Event listeners
    // ─────────────────────────────────────────────────────────────────────────

    // ─────────────────────────────────────────────────────────────────────────
    // Phone number auto-format: 10 digits → +91 XXXXX XXXXX
    // ─────────────────────────────────────────────────────────────────────────
    function formatPhoneNumber(val) {
        // Sirf digits rakhlo
        let digits = val.replace(/\D/g, '');

        // Leading 91 hata do agar 12 digits hai (country code already included)
        if (digits.length === 12 && digits.startsWith('91')) {
            digits = digits.slice(2);
        }

        // 10 digits se zyada nahi
        digits = digits.slice(0, 10);

        if (digits.length === 0) return '';
        if (digits.length <= 5) return '+91 ' + digits;
        return '+91 ' + digits.slice(0, 5) + ' ' + digits.slice(5);
    }

    container.addEventListener('input', function (e) {
        const inp = e.target;
        // Sirf contact (phone) inputs pe apply karo, email nahi
        if (
            inp.tagName === 'INPUT' &&
            inp.type === 'text' &&
            inp.closest('[data-field="contact"]')
        ) {
            const cursor = inp.selectionStart;
            const old    = inp.value;
            const formatted = formatPhoneNumber(old);
            if (formatted !== old) {
                inp.value = formatted;
                // Cursor end pe rakho formatting ke baad
                inp.setSelectionRange(formatted.length, formatted.length);
            }
        }
    });

    // + / email add — event delegation (dynamically added rows bhi handle hoti hain)
    container.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-add-entry');
        if (btn) addMultiEntry(btn);
    });

    const increaseBtn = document.getElementById('increaseBtn');
    const decreaseBtn = document.getElementById('decreaseBtn');

    if (increaseBtn) {
        increaseBtn.addEventListener('click', function () {
            if (personCount < MAX) {
                personCount++;
                updateCount();
                container.appendChild(createPersonCard(personCount, personCount - 1, {}));
            }
        });
    }

    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', function () {
            if (personCount > 1) {
                container.querySelectorAll('.person-card')[personCount - 1].remove();
                personCount--;
                updateCount();
            }
        });
    }

    // Same address checkbox
    const sameAddressChk = document.getElementById('sameAddress');
    if (sameAddressChk) {
        sameAddressChk.addEventListener('change', function () {
            const billTo = document.getElementById('billTo');
            const shipTo = document.getElementById('shipTo');
            if (!billTo || !shipTo) return;

            if (this.checked) {
                shipTo.value    = billTo.value;
                shipTo.readOnly = true;
                billTo._syncHandler = () => shipTo.value = billTo.value;
                billTo.addEventListener('input', billTo._syncHandler);
            } else {
                shipTo.readOnly = false;
                if (billTo._syncHandler) {
                    billTo.removeEventListener('input', billTo._syncHandler);
                }
            }
        });
    }

    // Global expose — inline onclick="removePerson(this)" ke liye
    window.removePerson = removePerson;

    renderInitial();

})();