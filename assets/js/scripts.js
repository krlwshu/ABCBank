// Register Form

(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.require-validation')
    console.log(forms);
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                console.log(form);

                form.classList.add('was-validated')
            }, false)
        })
})()


// Update DOB
let dob = document.getElementById('dob-input');
let mob = document.getElementById('mob-input');

dob.addEventListener('change', (e) => {
    //Set MOB
    const dateStr  = new Date(e.target.value);
    const month = dateStr.getMonth(dateStr)+1;
    (!Number.isNaN(month)) ? mob.value = month : mob.value = '';

});

//Default MOB
const dateStr  = new Date(dob.value);
const month = dateStr.getMonth(dateStr)+1;
(!Number.isNaN(month)) ? mob.value = month : mob.value = '';



const ymd = date => date.toISOString().slice(0,10);
//Min
maxDate = new Date();
maxDate.setFullYear( maxDate.getFullYear() - 18 );
dob.max = ymd(maxDate);




// Validate postcode
let postcode = document.getElementById('postcode-input');
postcode.addEventListener('change', (e) => {
    postcode.classList.remove('is-valid','is-invalid');
    const re = /^(([A-Z]{1,2}[0-9][A-Z0-9]?|ASCN|STHL|TDCU|BBND|[BFS]IQQ|PCRN|TKCA) ?[0-9][A-Z]{2}|BFPO ?[0-9]{1,4}|(KY[0-9]|MSR|VG|AI)[ -]?[0-9]{4}|[A-Z]{2} ?[0-9]{2}|GE ?CX|GIR ?0A{2}|SAN ?TA1)$/gi;
    const pcVal = e.target.value;
    (!pcVal.match(re)) ?  postcode.classList.add('is-invalid') : postcode.classList.add('is-valid');
});    



