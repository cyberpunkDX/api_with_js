const form = document.querySelector('#form');
const message = document.querySelector('#message');
const errorList = document.querySelector('#errors');
const button = document.querySelector('#submit');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    button.textContent = "Processing..";
    button.className = "btn btn-primary disabled"

    const payload = new FormData(form);
    const url = new URL(window.location.href);

    let pathname = url.pathname;
    let pathParts = pathname.split('/');
    let token = pathParts.pop();

    payload.append("token", token);

    console.log(payload);
    const request = new Request('http://127.0.0.1:8000/api/verify/user/token', {
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
            button.textContent = "Successful";
            button.className = "btn btn-success disabled"
            message.parentElement.className = "alert alert-success";
            message.textContent = data.message;
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
