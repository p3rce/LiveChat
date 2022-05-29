const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault(); //preventing form from submitting 
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest(); //Creating a XML object
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                inputField.value = ""; //once message inserted into database then leave input blank for next message
                scrollToBottom();
            }
        }
    }
    //Now we send the form data through ajax to php
    let formData = new FormData(form); //create new FormData object
    xhr.send(formData); //sending form data to php
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.add("active")
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.remove("active")
}

setInterval(()=>{
    let xhr = new XMLHttpRequest(); //Creating a XML object
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    let formData = new FormData(form); //create new FormData object
    xhr.send(formData); //sending form data to php
}, 500);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}