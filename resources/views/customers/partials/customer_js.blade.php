<script>
/* ---------------------------------------------
   CONTACT PERSON SECTION (Add / Remove / Validate)
--------------------------------------------- */
document.addEventListener('DOMContentLoaded', function(){
    const container = document.getElementById('contactsContainer');
    const template = document.getElementById('contactTemplate').innerHTML;
    let idx = 0;

    function addContact(data = null) {
        const html = template.replace(/__IDX__/g, idx);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        const item = wrapper.firstElementChild;

        item.querySelector('.contact-title').innerText = 'Contact #' + (idx+1);

        if (data) {
            if (data.name) item.querySelector('.contact-name').value = data.name;
            if (data.designation) item.querySelector('input[name="contacts['+idx+'][designation]"]').value = data.designation;
            if (data.phone) item.querySelector('input[name="contacts['+idx+'][phone]"]').value = data.phone;
            if (data.mobile) item.querySelector('input[name="contacts['+idx+'][mobile]"]').value = data.mobile;
            if (data.email) item.querySelector('input[name="contacts['+idx+'][email]"]').value = data.email;
            if (data.sms_report) item.querySelector('input[name="contacts['+idx+'][sms_report]"]').checked = true;
            if (data.sms_invoice) item.querySelector('input[name="contacts['+idx+'][sms_invoice]"]').checked = true;
            if (data.email_report) item.querySelector('input[name="contacts['+idx+'][email_report]"]').checked = true;
            if (data.email_invoice) item.querySelector('input[name="contacts['+idx+'][email_invoice]"]').checked = true;
        }

        item.querySelector('.remove-contact').addEventListener('click', function(){
            item.remove();
            refreshTitles();
        });

        const smsCheckboxes = item.querySelectorAll('.contact-sms-report, .contact-sms-invoice');
        const emailCheckboxes = item.querySelectorAll('.contact-email-report, .contact-email-invoice');

        function updateReq() {
            const mobileInput = item.querySelector('.contact-mobile');
            const emailInput = item.querySelector('.contact-email');
            const smsChecked = [...smsCheckboxes].some(ch => ch.checked);
            const emailChecked = [...emailCheckboxes].some(ch => ch.checked);

            if (smsChecked) mobileInput.setAttribute('required','required'); 
            else mobileInput.removeAttribute('required');

            if (emailChecked) emailInput.setAttribute('required','required'); 
            else emailInput.removeAttribute('required');
        }
        smsCheckboxes.forEach(ch => ch.addEventListener('change', updateReq));
        emailCheckboxes.forEach(ch => ch.addEventListener('change', updateReq));

        container.appendChild(item);
        idx++;
    }

    function refreshTitles(){
        const items = container.querySelectorAll('.contact-item');
        items.forEach((it,i) => {
            it.querySelector('.contact-title').innerText = 'Contact #' + (i+1);
        });
    }

    document.getElementById('addContactBtn').addEventListener('click', function(e){
        e.preventDefault();
        addContact();
    });

    const existing = window.existingContacts || [];
    if (existing.length) {
        existing.forEach(c => addContact(c));
    } else {
        addContact();
    }

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e){
            let bad = false;
            const items = container.querySelectorAll('.contact-item');
            items.forEach((it, i) => {
                const mobile = it.querySelector('.contact-mobile');
                const email = it.querySelector('.contact-email');
                const smsChecked = it.querySelector('.contact-sms-report').checked || it.querySelector('.contact-sms-invoice').checked;
                const emailChecked = it.querySelector('.contact-email-report').checked || it.querySelector('.contact-email-invoice').checked;
                if (smsChecked && (!mobile.value || mobile.value.trim() === '')) {
                    alert('Mobile is required for contact #' + (i+1) + ' because SMS option is selected.');
                    bad = true; return;
                }
                if (emailChecked && (!email.value || email.value.trim() === '')) {
                    alert('Email is required for contact #' + (i+1) + ' because Email option is selected.');
                    bad = true; return;
                }
            });
            if (bad) e.preventDefault();
        });
    }
});
</script>

<script>
/* ---------------------------------------------
   COUNTRY → STATE → CITY AJAX
   GST & PAN Auto-enable for India
--------------------------------------------- */
document.addEventListener('DOMContentLoaded', function(){
    const countrySelect = document.getElementById('country_select');
    const stateSelect = document.getElementById('state_select');
    const citySelect = document.getElementById('city_select');
    const stateCodeInput = document.getElementById('state_code');
    const gstin = document.getElementById('gstin');
    const pan = document.getElementById('pan');
    const sendSmsReport = document.getElementById('send_sms_report');
    const sendEmailReport = document.getElementById('send_email_report');
    const contactMobile = document.getElementById('contact_mobile');
    const contactEmail = document.getElementById('contact_email');

    countrySelect.addEventListener('change', async function(){
        const countryId = this.value;
        stateSelect.innerHTML = '';
        citySelect.innerHTML = '';
        stateCodeInput.value = '';
        gstin.disabled = true;
        pan.disabled = true;
        if(!countryId) {
            stateSelect.disabled = true;
            citySelect.disabled = true;
            return;
        }
        try {
            const res = await axios.get(`/api/countries/${countryId}/states`);
            const states = res.data;
            stateSelect.disabled = false;
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            states.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.text = s.name;
                opt.dataset.stateCode = s.state_code;
                stateSelect.appendChild(opt);
            });
        } catch(e){ console.error(e); }
    });

    stateSelect.addEventListener('change', async function(){
        const stateId = this.value;
        citySelect.innerHTML = '';
        stateCodeInput.value = '';
        gstin.disabled = true;
        pan.disabled = true;
        if(!stateId) { citySelect.disabled = true; return; }

        const selected = stateSelect.options[stateSelect.selectedIndex];
        if(selected && selected.dataset && selected.dataset.stateCode) {
            stateCodeInput.value = selected.dataset.stateCode || '';
        }

        try {
            const res = await axios.get(`/api/states/${stateId}/cities`);
            const cities = res.data;
            citySelect.disabled = false;
            citySelect.innerHTML = '<option value="">-- Select City --</option>';
            cities.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.text = c.name;
                citySelect.appendChild(opt);
            });
        } catch(e){ console.error(e); }
    });

    citySelect.addEventListener('change', async function(){
        const cityId = this.value;
        if(!cityId) return;
        try {
            const res = await axios.get(`/api/cities/${cityId}`);
            const city = res.data;
            const countryName = city.state.country.name;

            const isIndia = countryName.trim().toLowerCase() === 'india';
            gstin.disabled = !isIndia;
            pan.disabled = !isIndia;

            document.getElementById('state_code').value = city.state.state_code || '';
        } catch(err){ console.error(err); }
    });

    document.getElementById('customerForm').addEventListener('submit', function(e){
        const smsRequired = sendSmsReport.checked;
        const emailRequired = sendEmailReport.checked;

        if( (smsRequired && !contactMobile.value) ||
            (emailRequired && !contactEmail.value) ){
            e.preventDefault();
            alert('Mobile required for SMS, Email required for Email.');
        }
    });
});
</script>
