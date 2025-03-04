const form = document.querySelector('#form');
const message = document.querySelector('#message');
const errorList = document.querySelector('#errors');
const button = document.querySelector('#submit');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    button.textContent = "Processing..";
    button.className = "btn btn-primary disabled"

    const payload = new FormData(form);
    const request = new Request('http://127.0.0.1:8000/api/register/store', {
        method: 'POST',
        body: payload,
    });

    try {
        const response = await fetch(request);
        const data = await response.json();

        errorList.innerHTML = '';
        if (data.errors) {
            Object.entries(data.errors).forEach(([field, messages]) => {
                messages.forEach(message => {
                    const listItem = createListItem(`${field}: ${message}`);
                    errorList.appendChild(listItem);
                    errorList.parentElement.className = "alert alert-danger";
                });
            });

        } else {
            message.parentElement.className = "alert alert-success";
            message.textContent = data.message;

            const userToken = data.token;
            const baseURL = "http://127.0.0.1:8000/register/verify/";
            const fullURL = `${baseURL}${userToken}`;
            setTimeout(function() {
                window.location.href = fullURL;
            }, 5000);
        }
    } catch (errors) {
        console.error('Error:', errors);
    }
});

function createListItem(value) {
    const listItem = document.createElement('li');
    listItem.textContent = value;
    return listItem;
}



async function view(url) {

    const request = new Request(url);
    await fetch(request)
    .then(response => response.json())
    .then(data => {
        console.log(data)
    })
    .catch(error => console.log(error));
}


