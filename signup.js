function jsonCheckEmail(json) {
    // Controllo il campo exists ritornato dal JSON -- EMAIL
    if (formStatus.email = !json.exists) {
        document.querySelector('.email').classList.remove('close_error');
    } else {
        document.querySelector('.email span').textContent = "Email in uso";
        document.querySelector('.email').classList.add('close_error');
    }
}

function jsonCheckUsername(json) {
    // Controllo il campo exists ritornato dal JSON -- USERNAME
    if (formStatus.username = !json.exists) {
        document.querySelector('.username').classList.remove('close_error');
    } else {
        document.querySelector('.username span').textContent = "Username in uso";
        document.querySelector('.username').classList.add('close_error');
    }
}

function Response(response) {
    if (!response.ok) return null;
    return response.json();
}


function f_CheckNome(event){
    const name_input = document.querySelector('.name input');
    name_input.parentNode.classList.remove('close_error');

    if (!/^[a-zA-Z]{1,20}$/.test(name_input.value)) {
        name_input.parentNode.querySelector('span').textContent = "Il nome deve contenere solo lettere";
        name_input.parentNode.classList.add('close_error');
    }
}

function f_CheckCognome(event){
    const cognome_input = document.querySelector('.cognome input');
    cognome_input.parentNode.classList.remove('close_error');

    if (!/^[a-zA-Z]{1,20}$/.test(cognome_input.value)) {
        cognome_input.parentNode.querySelector('span').textContent = "Sono ammesse solo lettere";
        cognome_input.parentNode.classList.add('close_error');
    }
}

function f_CheckUsername(event) {
    const username_input = document.querySelector('.username input');
    username_input.parentNode.classList.remove('close_error');

    if (!/^[a-zA-Z0-9]{1,15}$/.test(username_input.value)) {
        username_input.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri, underscore. Max. 15";
        username_input.parentNode.classList.add('close_error');
    } else {
      fetch("check_username.php?q=" + encodeURIComponent(username_input.value)).then(Response).then(jsonCheckUsername);
    }
}
  
function f_CheckEmail(event) {
    const email_input = document.querySelector('.email input');
    email_input.parentNode.classList.remove('close_error');

    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email_input.value).toLowerCase())) {
        email_input.parentNode.querySelector('span').textContent = "Formato non valido";
        email_input.parentNode.classList.add('close_error');
    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(email_input.value).toLowerCase())).then(Response).then(jsonCheckEmail);
    }
}

function f_CheckPassword(event) {
    const password_input = document.querySelector('.password input');
    password_input.parentNode.classList.remove('close_error');
    const regExp = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,15})");

    if (!regExp.test(password_input.value)) {
        password_input.parentNode.querySelector('span').textContent = "Almeno 8 caratteri, una lettera maiuscola, un numero e un carattere speciale";
        password_input.parentNode.classList.add('close_error');
    } 
}

function f_CheckVerifyPassword(event) {
    const c_password_input = document.querySelector('.confirm_password input');
    c_password_input.parentNode.classList.remove('close_error');
    const regExp = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,15})");

    if (!regExp.test(c_password_input.value)) {
        c_password_input.parentNode.querySelector('span').textContent = "Almeno 8 caratteri, una lettera maiuscola, un numero e un carattere speciale";
        c_password_input.parentNode.classList.add('close_error');
    } 
}

function checkUpload(event) {
    const upload_original = document.getElementById('upload_original');
    document.querySelector('#upload .file_name').textContent = upload_original.files[0].name;
    const o_size = upload_original.files[0].size;
    const mb_size = o_size / 1000000;
    document.querySelector('#upload .file_size').textContent = mb_size.toFixed(2)+" MB";
    const ext = upload_original.files[0].name.split('.').pop();

    if (o_size >= 7000000) {
        document.querySelector('.fileupload span').textContent = "Le dimensioni del file superano 7 MB";
        document.querySelector('.fileupload').classList.add('close_error');
        formStatus.upload = false;
    } else if (!['jpeg', 'jpg', 'png', 'gif'].includes(ext))  {
        document.querySelector('.fileupload span').textContent = "Le estensioni consentite sono .jpeg, .jpg, .png e .gif";
        document.querySelector('.fileupload').classList.add('close_error');
        formStatus.upload = false;
    } else {
        document.querySelector('.fileupload').classList.remove('close_error');
        formStatus.upload = true;
    }
}

function clickSelezionaFile(event) {
    upload_original.click();
}


document.querySelector('.name input').addEventListener('keyup', f_CheckNome);
document.querySelector('.cognome input').addEventListener('keyup', f_CheckCognome);
document.querySelector('.username input').addEventListener('keyup', f_CheckUsername);
document.querySelector('.email input').addEventListener('keyup', f_CheckEmail);
document.querySelector('.password input').addEventListener('keyup', f_CheckPassword);
document.querySelector('.confirm_password input').addEventListener('keyup', f_CheckVerifyPassword);
document.getElementById('upload').addEventListener('click', clickSelezionaFile);
document.getElementById('upload_original').addEventListener('change', checkUpload);

