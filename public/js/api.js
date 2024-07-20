

const form = document.querySelector('#form');
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const message = document.querySelector('#message');

form.addEventListener('submit', async function(e){
    e.preventDefault();

    const payload = new FormData(form);
    const request = new Request('http://127.0.0.1:8000/api/register/store', {
        method: 'POST',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        body: payload,
    });

    await fetch(request)
    .then(response => response.json())
    .then(data => {
        console.log(data);

        message.textContent = data.message

        if (data.errors) {
            data.errors.forEach(createListItem);
        }

        if (data.status == "success") {
            message.className = "alert alert-success"
        } else {
            message.className = "alert alert-danger"
        }
    })
    .catch(error => console.error('Error:', error));

});

function createListItem (value) {
    const listItem = document.createElement('li');
    listItem.textContent = value
}

