let email = document.getElementById('email')
let password = document.getElementById("password")
let repeat_password = document.getElementById("repeat_password")
let first_name = document.getElementById("first_name")
let given_name = document.getElementById("given_name")
let street_name = document.getElementById("street_name")
let street_number = document.getElementById("street_number")
let post_code = document.getElementById("post_code")
let city = document.getElementById("city")
let phone_number = document.getElementById("phone_number")
let form = document.getElementById("signupForm")

let error = document.getElementById("error")
let pwRegx = new RegExp("(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})")

form.addEventListener('submit', (ev => {
    let messages = []
    if (pwRegx.test(password.value)) {
        messages.push("The password must contain at least one upper case letter, one lower case letter and one number")
    }

    if (messages.length > 0){
        ev.preventDefault()
        error.innerText = messages.join(', ')
    }
    console.log("Event called")
}))
