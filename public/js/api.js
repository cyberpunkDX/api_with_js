const form = document.querySelector('#form');
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const message = document.querySelector('#message');
const errorList = document.querySelector('#errors');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const payload = new FormData(form);
    const request = new Request('http://127.0.0.1:8000/api/register/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
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
            window.location.href = "http://127.0.0.1:8000/register/verify";
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


