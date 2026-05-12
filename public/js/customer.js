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

    // ─────────────────────────────────────────────────────────────────────────
    // Full person card banana (blank ya pre-filled)
    // ─────────────────────────────────────────────────────────────────────────
    function createPersonCard(displayNum, arrayIdx, data) {
        data = data || {};

        // DB mein contact field ka naam alag ho sakta hai — dono handle karo
        const contacts = data.contact ?? data.phones ?? [];
        const emails   = data.email   ?? data.emails  ?? [];

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
            </div>`;

        return div;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // + button click → naya row add karo
    // ─────────────────────────────────────────────────────────────────────────
    function addMultiEntry(btn) {
        const type    = btn.dataset.type;
        const wrap    = btn.closest('.multi-entry');
        const idx     = wrap.dataset.idx;
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
                el.name = el.name.replace(/contact_persons\[\d+\]/, `contact_persons[${i}]`);
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