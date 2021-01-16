const q = e => document.querySelector(e);

const usernameRegex = /^[a-zA-Z ąćęółńżźśĄĆĘÓŁŃŻŹŚ]{5,49}[a-zA-ZąćęółńżźśĄĆĘÓŁŃŻŹŚ]*$/;
const phoneRegex = /(\+\d{10,12}|\d{9})/;

let wasChecked1 = false, wasChecked2 = false;

setInterval(validate_signup, 100);
setInterval(validate_login, 100);

q('#signup-eula').onchange = e => { wasChecked1 = true; };
q('#signup-is-parent').onchange = e => { wasChecked2 = true; };

q('#signup-form').onsubmit = e => {
	q('#signup-submit-div').hidden = true;
 	q('#signup-submit-blocked-div').hidden = false;
};

function validate_signup(e) {
	let canUpload = true;

	canUpload &= (q('#signup-username').value.length != 0);
	canUpload &= (q('#signup-telephone').value.length != 0);
	canUpload &= (q('#signup-pass-1').value.length != 0);
	canUpload &= (q('#signup-pass-2').value.length != 0);
	canUpload &= (q('#signup-eula').checked);
	canUpload &= (q('#signup-is-parent').checked);

	{
		const t = q('#signup-username');
		const err = t.parentElement.querySelector('.err');
		if(usernameRegex.test(t.value) || t.value.length == 0) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	{
		const t = q('#signup-telephone');
		const err = t.parentElement.querySelector('.err');
		if(phoneRegex.test(t.value) || t.value.length == 0) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	{
		const t1 = q('#signup-pass-1');
		const t2 = q('#signup-pass-2');
		const err = t2.parentElement.querySelector('.err');
		if(t1.value == t2.value || t1.value.length == 0 || t2.value.length == 0) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	{
		const t = q('#signup-eula');
		const err = t.parentElement.querySelector('.err');
		if(t.checked || !wasChecked1) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	{
		const t = q('#signup-is-parent');
		const err = t.parentElement.querySelector('.err');
		if(t.checked || !wasChecked2) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	q('#signup-submit-div').hidden = !canUpload;
 	q('#signup-submit-blocked-div').hidden = canUpload;
}

function validate_login(e) {

	let canUpload = true;

	canUpload &= (q('#login-telephone').value.length != 0);
	canUpload &= (q('#login-password').value.length != 0);

	{
		const t = q('#login-telephone');
		const err = t.parentElement.querySelector('.err');
		if(phoneRegex.test(t.value) || t.value.length == 0) {
			err.hidden = true;
		} else {
			err.hidden = false;
			canUpload = false;
		}
	}

	q('#login-submit-div').hidden = !canUpload;
 	q('#login-submit-blocked-div').hidden = canUpload;

}