document.addEventListener('DOMContentLoaded', async () => {
    const apiUrl = '/wp-json/fwrgpd/datas/';
    let jsondata;

    try {
        // Retrieve data via fetch
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        jsondata = JSON.parse(data); // Storing the JSON response

        // Call the function to insert the popup into the DOM
        if(jsondata.config.status.as_to_be_displayed == true){
        	insertPopup(jsondata);
        }
        

        // Attach jsondata to window to make it globally accessible
        window.fwrgpdjsondata = jsondata;
    } catch (error) {
        console.error('Error while retrieving data:', error);
    }
});

// Function to insert the popup
function insertPopup(jsondata) {
    const fwRgpdPopupContainer = document.createElement("div");
    fwRgpdPopupContainer.setAttribute("id", "fw_rgpd_popup_container");
    fwRgpdPopupContainer.innerHTML = jsondata.popupContent;
    document.body.appendChild(fwRgpdPopupContainer);
    document.documentElement.style.overflowY = "hidden";
}

// Function to close the popup (rendered global)
window.closeFwRGPDPopup = function () {
    const fwSwitchs = document.getElementsByClassName("fw_rgpd_switch_input");
    const fwPrefix = window.fwrgpdjsondata.config.cookies_prefix; 
    const cookies = window.fwrgpdjsondata.config.sections;
    const domain =  window.fwrgpdjsondata.config.domain;

    for (let i = 0; i < fwSwitchs.length; i++) {
        const key = fwSwitchs[i].getAttribute('data-key');
        const expirationDays = cookies[i].expiration_days;

        fwRgpdModifyCookie(fwPrefix + key, fwSwitchs[i].checked ? 1 : 0, expirationDays, domain);
    }

    document.getElementById("fw_rgpd_popup_container").style.display = "none";
    document.documentElement.style.overflowY = "auto";
    window.location.reload();
};

// Function to save preferences (render global)
window.saveFwRGPDPreferences = function () {
    const fwSwitchs = document.getElementsByClassName("fw_rgpd_switch_input_cookies_page");
    const fwPrefix = window.fwrgpdjsondata.config.cookies_prefix; 
    const cookies = window.fwrgpdjsondata.config.sections;
    const domain =  window.fwrgpdjsondata.config.domain;

    for (let i = 0; i < fwSwitchs.length; i++) {
        const key = fwSwitchs[i].getAttribute('data-key');
        const expirationDays = cookies[i].expiration_days;

        fwRgpdModifyCookie(fwPrefix + key, fwSwitchs[i].checked ? 1 : 0, expirationDays, domain);
    }

    const button = document.getElementById("fw_rgpd_save_preference_button");
    const originalText = button.textContent;

    button.textContent = button.getAttribute('data-savetxt');
    button.disabled = true;

    setTimeout(() => {
        button.textContent = originalText;
        button.disabled = false;
    }, 2000);
};

// Function to modify cookies
function fwRgpdModifyCookie(cookieName, cookieValue, expirationDays, domain) {
    const d = new Date();
    d.setTime(d.getTime() + expirationDays * 24 * 60 * 60 * 1000);
    const expires = "expires=" + d.toUTCString();
    document.cookie = `${cookieName}=${cookieValue};${expires};domain=${domain};path=/;`;
}
