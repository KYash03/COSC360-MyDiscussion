document.addEventListener("DOMContentLoaded",function(){
    const form = document.getElementById("login-form");
    const username = document.querySelector('input[name="username"]');
    const password = document.querySelector('input[name="password"]');


    form.addEventListener("submit",function(event){
        let isFormValid = true;

        if(!username.value.trim()){
            username.classList.add('highlight');
            isFormValid = false;

        }
        if(!password.value.trim()){
            password.classList.add('highlight');
            isFormValid = false;

        }


        //prevent empty and invalid form submission
        if(!isFormValid){
            event.preventDefault();
            alert("Please fill all required fields");

        }

    });
    function removeHighlight(event){
        if(event.target.value.trim()){
            event.target.classList.remove('highlight')
        }
    }

    username.addEventListener('input',removeHighlight);
    description.addEventListener('input',removeHighlight);
});

document.addEventListener("DOMContentLoaded",function(){
    const form = document.getElementById("signup-form");
    const name = document.querySelector('input[name="name"]');
    const lastname = document.querySelector('input[name="lastname"]');
    const username = document.querySelector('input[name="username"]');
    const password = document.querySelector('input[name="password"]');
    const email = document.querySelector('input[name="email"]');
    const acceptLicense = document.querySelector('input[name="accept"]');


    form.addEventListener("submit",function(event){
        let isFormFilled = true;
        let isFormValid = true;
        let list =[];



        if(!name.value.trim()){
            name.classList.add('highlight');
            isFormFilled = false;
            list.append("First name");

        }
        if(hasNumbers(name)){
            isFormValid =false;
            name.classList.add('highlight');
        }
        
        if(!lastname.value.trim()){
            lastname.classList.add('highlight');
            isFormFilled = false;
            list.append("Last name");

        }
        if(hasNumbers(lastname)){
            isFormValid =false;
            lastname.classList.add('highlight');
        }
        if(!email.value.trim()){
            username.classList.add('highlight');
            isFormFilled = false;
            list.append("E-mail");

        }

        if(!username.value.trim()){
            username.classList.add('highlight');
            isFormFilled = false;
            list.append("username");

        }
        if(!password.value.trim()){
            password.classList.add('highlight');
            isFormFilled = false;
            list.append("password");

        }
        if(!acceptLicense.checked){
            acceptLicense.classList.add('highlight');
            isFormValid = false;

        }


        //prevent empty and invalid form submission
        if(!isFormFilled){
            event.preventDefault();
            alert("Please fill the following fields: " + list);

        }
        if(!isFormValid){
            event.preventDefault();
            alert("Please fill the fields correctly and accept the license.");

        }






    });


    function removeHighlight(event){
        if(event.target.value.trim()){
            event.target.classList.remove('highlight')
        }
    }

    name.addEventListener('input',removeHighlight);
    lastname.addEventListener('input',removeHighlight);
    email.addEventListener('input',removeHighlight);
    username.addEventListener('input',removeHighlight);
    password.addEventListener('input',removeHighlight);
});