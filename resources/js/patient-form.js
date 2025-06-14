// Functions used in patient creation form
export function calculateBirthdateOrAge() {
  const age = document.getElementById('age').value;
  const birthdateInput = document.getElementById('birth_date');
  if (age) {
    const now = new Date();
    const birthdate = new Date(now.getFullYear() - age, now.getMonth(), now.getDate());
    const formattedBirthdate = formatDate(birthdate);
    birthdateInput.value = formattedBirthdate;
  } else {
    birthdateInput.value = '';
  }
}

export function calculateAgeOrBirthdate() {
  const birthdate = document.getElementById('birth_date').value;
  const ageInput = document.getElementById('age');
  if (birthdate) {
    const now = new Date();
    const birthdateDate = new Date(birthdate);
    const age = now.getFullYear() - birthdateDate.getFullYear();
    ageInput.value = age;
  } else {
    ageInput.value = '';
  }
}

function formatDate(date) {
  const year = date.getFullYear();
  let month = 6; // date.getMonth() + 1;
  let day = 1; // date.getDate();
  month = month < 10 ? `0${month}` : month;
  day = day < 10 ? `0${day}` : day;
  return `${year}-${month}-${day}`;
}

export function generateRandomCode(length) {
  const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  let code = '';
  const now = new Date();
  for (let i = 0; i < length; i++) {
    code += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return `P${now.getFullYear()}-${code}`;
}

export function insertRandomCode() {
  const randomCode = generateRandomCode(6);
  const codeField = document.getElementById('code');
  if (codeField) {
    codeField.value = randomCode;
  }
}
