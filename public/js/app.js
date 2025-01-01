
function toggleOther(contentReadyElement) {
    if ($(contentReadyElement).val() === "email") {
        $('#email').attr('required', true);
        $('#phone').attr('required', false);
    } else if ($(contentReadyElement).val() === "phone") {
        $('#email').attr('required', false);
        $('#phone').attr('required', true); ;
    }
}


function toggleOtherDiv(contentReadyId, otherDivId, contentReadyOtherId) {
    if ($(`#${contentReadyId}`).val() === "other") {
        $(`#${otherDivId}`).css('display', 'block');
        $(`#${contentReadyOtherId}`).attr('required', true);
    } else {
        $(`#${otherDivId}`).css('display', 'none');
        $(`#${contentReadyOtherId}`).removeAttr('required');
    }
}

function characterCounterByConfigurations(configurations) {
    document.addEventListener('DOMContentLoaded', function () {
        // Iterate through each configuration object
        configurations.forEach(function ({ id, limit }) {
            var textarea = document.getElementById(id);

            if (!textarea) return; // Exit if the textarea element is not found

            // Create a counter span element next to the textarea if it doesn't exist
            var counterId = id + '-counter';
            var existingCounter = document.getElementById(counterId);
            var counter;

            if (!existingCounter) {
                counter = document.createElement('span');
                counter.id = counterId;
                textarea.parentNode.insertBefore(counter, textarea.nextSibling);
            } else {
                counter = existingCounter;
            }

            // Update the counter initially with the current value
            updateCounter();

            // Add input event listener to update character count dynamically
            textarea.addEventListener('input', updateCounter);

            function updateCounter() {
                var currentLength = textarea.value.length;
                counter.textContent = `${currentLength}/${limit} characters used`;
            }
        });
    });
}

function characterCounterByArrayOfId(textareaIds, maxLength) {
        document.addEventListener('DOMContentLoaded', function () {
            // loop through all textarea IDs
            textareaIds.forEach(function (textareaId) {
                var textarea = document.getElementById(textareaId);

                if (!textarea) return; // Exit if the textarea element is not found

                // Create a counter span element next to textarea if it doesn't exist
                var counterId = textareaId + '-counter';
                var existingCounter = document.getElementById(counterId);
                var counter;

                if (!existingCounter) {
                    counter = document.createElement('span');
                    counter.id = counterId;
                    textarea.parentNode.insertBefore(counter, textarea.nextSibling);
                } else {
                    counter = existingCounter;
                }

                // Update the counter initially with the current value
                updateCounter();

                // Add input event listener to update character count
                textarea.addEventListener('input', updateCounter);

                function updateCounter() {
                    var currentLength = textarea.value.length;
                    counter.textContent = currentLength + '/' + maxLength + ' characters used';
                }
            });
        });
    }


    function checkToggle(toggle) {
        /* https://www.techiedelight.com/change-elements-display-to-none-or-block-javascript/ */
        if (toggle.style.display !== "none") {
            toggle.style.display = "none";
        } else {
            toggle.style.display = "block";
        }
    }

    function checkchange(change) {
        if (change.checked === true) {
            document.getElementById('showpass').setAttribute('style', 'display: block;');
            document.getElementById('passcode').required = true;
            document.getElementById('confirmpass').required = true;
        } else {
            document.getElementById('confirmpass').required = false;
            document.getElementById('passcode').required = false;
            document.getElementById('showpass').setAttribute('style', 'display: none;');
        }
    }

    function changepasselement(pwdi, pass) {
        // change lock on password from locked to unlocked
        if (pwdi.matches('.fi-lock')) {
            pwdi.classList.remove('fi-lock');
            pwdi.classList.add('fi-unlock');
            pass.setAttribute('type', 'text');
        } else {
            pwdi.classList.remove('fi-unlock');
            pwdi.classList.add('fi-lock');
            pass.setAttribute('type', 'password');
        }
    }

    function checkUserName(uname, hidden) {
        if (hidden.value === 'new') {
            uname.readOnly = false;
        } else {
            /* uname.readOnly = true; */
        }

    }

    function checkphone(phone) {
        phone.value = formatPhoneNumber(phone);
        phone.addEventListener('input', function () {
            phone.value = formatPhoneNumber(phone);
        });
    }

    function formatPhoneNumber(phone) {
        let phoneNumber = ('' + phone.value).replace(/[^\d]/g, '');
        if (phoneNumber.length < 2) return phoneNumber;
        if (phoneNumber.length < 4) return phoneNumber.replace(/(\d{0,3})/, "($1");
        if (phoneNumber.length < 7) return phoneNumber.replace(/(\d{0,3})(\d{0,3})/, "($1) $2");
        return phoneNumber.replace(/(\d{0,3})(\d{0,3})(\d{0,4})/, "($1) $2-$3");
    }

    function getCategory(dept, category) {
        let opt;
        for (let i = 0, len = category.options.length; i < len; i++) {
            opt = category.options[i];
            if (opt.selected === true) {
                break;
            }
        }
        dept.value = opt.text;
    }

    function addInputElements() {
        // generate number of levels to input values
        let floorelement = document.getElementById('floors');
        let floors = floorelement.value;
        console.log(floorelement);
        // get element where the nodes will be placed
        let container = document.getElementById('addelements');
        // remove any active nodes within this element
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
        let fieldset = document.createElement("FIELDSET");
        fieldset.className = 'callout';
        container.appendChild(fieldset);
        let legend = document.createElement('LEGEND');
        legend.innerHTML = '# of Rooms on Each Level';
        fieldset.appendChild(legend);
        for (let x = 1; x <= floors; x++) {
            // append a node
            let helptext = document.createElement("P");
            helptext.className = 'help-text';
            helptext.id = 'helplevel' + x;
            let level = document.createElement("INPUT");
            level.id = 'level' + x;
            level.name = 'level' + x;
            level.type = 'number';
            level.min = '1';
            level.max = '50';
            level.setAttribute('aria-describedby', 'helplevel' + x)
            level.required = true;
            if (x > 1) {
                level.value = '30';
            } else {
                level.value = '6';
            }
            // container.appendChild(level);
            let label = document.createElement("LABEL");
            label.setAttribute('for', 'level' + x);
            label.innerHTML = 'Level ' + x;
            label.appendChild(level);
            fieldset.appendChild(label);
            let p = fieldset.appendChild(helptext);
            p.innerHTML = 'How many rooms for level ' + x;
            //container.appendChild(document.createTextNode('Test '+x));
        }
    }

    function uncheckall(prob, catname, num) {
        for (let x = 0; x < num; x++) {
            let cat = document.getElementById((catname + x));
            if (cat.checked) {
                cat.checked = false;
                prob.checked = false;
            }
        }
    }

    function addOptionElement(classvalue, methods, choose) {
        // console.log(classvalue);
        //let classelement = document.getElementById('selectclass');
        //let classvalue = classelement.options[classelement.selectedIndex].text;
        //console.log(methods[classvalue]);
        selectclass = document.getElementById("selectclass");
        let select = document.getElementById('selectmethod');
        let selectaction = document.getElementById('selectoption');
        let url = document.getElementById('url');
        if (selectclass.options[selectclass.selectedIndex].value === '') {
            url.setAttribute('value', '');
            if (select.disabled === false) {
                select.setAttribute("disabled", "");
            }
            if (selectaction.disabled === false) {
                selectaction.setAttribute("disabled", "");
            }
        } else if (classvalue !== '') {
            while (select.hasChildNodes()) {
                select.removeChild(select.lastChild);
            }
            let option = document.createElement("option");
            option.setAttribute("value", "");
            option.appendChild(document.createTextNode("Choose A Method"));
            select.appendChild(option);
            for (let mymethod in methods[classvalue]) {
                //console.log(methods[classvalue][mymethod]);
                option = document.createElement("option");
                option.setAttribute("value", methods[classvalue][mymethod]);
                //console.log(methods[classvalue][mymethod]);
                if (methods[classvalue][mymethod] === choose) {
                    option.setAttribute("selected", true);
                }
                // change to uppercase use .toUpperCase()
                optiontext = document.createTextNode((methods[classvalue][mymethod])[0].toUpperCase() + methods[classvalue][mymethod].substring(1));
                option.appendChild(optiontext);
                select.appendChild(option);
            }
            let ce = document.getElementById('selectclass')
            //console.log(ce.options[ce.selectedIndex].value);
            //console.log(select.options[select.selectedIndex].value);
            url.setAttribute('value', (ce.options[ce.selectedIndex].value + '/'));
            if (select.disabled) {
                select.removeAttribute("disabled");
                select.focus();
            }
        }
    }

    function addActionElement(methodvalue, actions, choose) {
        //console.log(actions[methodvalue]);
        let select = document.getElementById('selectoption');
        if (methodvalue !== '') {
            while (select.hasChildNodes()) {
                select.removeChild(select.lastChild);
            }
            let option = document.createElement("option");
            option.setAttribute("value", "");
            option.appendChild(document.createTextNode("Choose an Action"));
            select.appendChild(option);
            for (let myaction in actions[methodvalue]) {
                //console.log(myaction + ": "+actions[methodvalue][myaction]);
                option = document.createElement("option");
                option.setAttribute("value", myaction);
                console.log(myaction);
                if (myaction === choose) {
                    option.setAttribute("selected", true);
                }
                option.appendChild(document.createTextNode(actions[methodvalue][myaction]));
                select.appendChild(option);
            }
            let ce = document.getElementById("selectclass");
            let url = document.getElementById("url");
            let me = document.getElementById("selectmethod");
            url.setAttribute('value', (ce.options[ce.selectedIndex].value + '/' + me.options[me.selectedIndex].value + '/'));
            if (select.disabled) {
                select.removeAttribute("disabled");
                select.focus();
            }
        } else {
            if (select.disabled === false) {
                select.setAttribute("disabled", "");
            }
        }
    }

    function addActionUrl(action) {
        let ce = document.getElementById("selectclass");
        let me = document.getElementById("selectmethod");
        let url = document.getElementById("url");
        if (ce.options[ce.selectedIndex].value !== "" && me.options[me.selectedIndex].value !== "") {
            url.setAttribute('value', (ce.options[ce.selectedIndex].value + '/' + me.options[me.selectedIndex].value + '/' + action.options[action.selectedIndex].value));
        }
    }

    function calculateUnitTotal() {
        let total = document.getElementById("prodtotaluqty");
        let unitqty = document.getElementById("produnitqty").value;
        let uq = document.getElementById("prodqu").value;
        let cq = document.getElementById("prodcq").value;
        // if (uq === 0) {
        // 	uq = 1;
        // }
        if (cq === 0) {
            cq = 1;
        }
        let tqty = unitqty * uq * cq;
        let tqtyfixed = tqty.toFixed(3);
        let tqtyformat = formatNumber(tqtyfixed);
        total.setAttribute('value', tqtyformat);
    }

    function formatNumber(val) {
        // taken from https://www.tutorialstonight.com/javascript-number-format
        // remove sign if negative
        let sign = 1;
        if (val < 0) {
            sign = -1;
            val = -val;
        }
        // trim the number decimal point if it exists
        let num = val.toString().includes('.') ? val.toString().split('.')[0] : val.toString();
        let len = num.toString().length;
        let result = '';
        let count = 1;

        for (let i = len - 1; i >= 0; i--) {
            result = num.toString()[i] + result;
            if (count % 3 === 0 && count !== 0 && i !== 0) {
                result = ',' + result;
            }
            count++;
        }

        // add number after decimal point
        if (val.toString().includes('.')) {
            result = result + '.' + val.toString().split('.')[1];
        }
        // return result with - sign if negative
        return sign < 0 ? '-' + result : result;
    }

    function validateSchema(data, schema) {
        for (const key of schema.required) {
            if (!(key in data)) {
                return {valid: false, error: `Missing required key: ${key}`};
            }
        }
        return {valid: true, data};
    }

    function validateJSON(jsonString, schema = null) {
        try {
            // parse the JSON string
            const data = JSON.parse(jsonString);

            // optional schema validation (if schema is provided)
            if (schema) {
                return validateSchema(data, schema);
            }
            // if no schema provided, just ensure it parsed successfully
            return {valid: true, data};
        } catch (e) {
            // if parsing failed, return invalid result
            return {valid: false, comment: "There is an error in JSON Data!", error: e.message};
        }
    }

    function validateSiteData(jsonString, dev = null) {
        const errorMessageElement = document.getElementById('errorMessage');
        try {
            const schema = getCompanySchema();
            const data = validateJSON(jsonString.value, schema);
            if (data.valid === true) {
                errorMessageElement.textContent = "JSON is valid!";
                errorMessageElement.style.color = "green";
                console.log("Valid JSON data:", data);
            } else {
                errorMessageElement.textContent = "JSON NOT acceptable!";
                errorMessageElement.style.color = "red";

            }
        } catch (error) {
            errorMessageElement.textContent = "Invalid JSON: " + error.message;
            errorMessageElement.style.color = "red";
            return {valid: false};
        }
    }

    function getCompanySchema() {
        return {
            required: [
                'frontdesk',
                'buttonclass',
                'shuttle',
                'generator',
                'passlength',
                'userlength',
                'firstname',
                'lastname',
                'timezone',
                'floors',
                'level1',
                'level2',
                'level3',
                'level4',
                'tokenexpire',
                'tokensize',
                'host',
                'hostuser',
                'hostpass',
                'debug'
            ]
        };
    }

    function submitCompanyForm() {
        const jsonInput = document.getElementById('sitedata').value;
        const errorMessageElement = document.getElementById('errorMessage');

        try {
            const schema = getCompanySchema();

            const data = validateJSON(jsonInput, schema);
            if (data.valid === true) {
                errorMessageElement.textContent = "JSON is valid!";
                errorMessageElement.style.color = "green";

                console.log("Valid JSON data:", data);
            } else {
                errorMessageElement.textContent = "JSON NOT acceptable!";
                errorMessageElement.style.color = "red";
                return false;
            }
        } catch (error) {
            errorMessageElement.textContent = "Invalid JSON: " + error.message;
            errorMessageElement.style.color = "red";
            return false;
        }
        return false;
    }

// {"frontdesk": "7654502009", "buttonclass": "button hollow", "shuttle": 0, "generator": 0, "passlength": 8, "userlength": 7, "firstname": 2, "lastname": 2, "timezone": "America\/Indiana\/Indianapolis", "floors": 4, "level1": 6, "level2": 30, "level3": 30, "level4": 30, "tokenexpire": 20, "tokensize": 32, "host": "this is the host", "hostuser": "host user", "hostpass": "host password", "debug": "true"}


