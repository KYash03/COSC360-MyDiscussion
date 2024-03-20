document.addEventListener("DOMContentLoaded",function(){
    const form = document.getElementById("posting-form");
    const title = document.querySelector('input[name="postTitle"]');
    const content = document.querySelector('input[name="postContent"]');


    form.addEventListener("submit",function(event){
        let isFormValid = true;

        if(!title.value.trim()){
            content.classList.add('highlight');
            isFormValid = false;

        }
        if(!content.value.trim()){
            content.classList.add('highlight');
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

    title.addEventListener('input',removeHighlight);
    content.addEventListener('input',removeHighlight);
});
