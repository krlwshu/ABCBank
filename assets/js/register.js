// Set Focus
let apply = document.getElementById('apply');
apply.addEventListener('click', (e) => {
    window.setTimeout(function () { 
        document.getElementById('fname-input').focus();
    }, 500);    
});  
