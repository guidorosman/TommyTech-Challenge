let apiForm = document.getElementById('api-form');
let title = document.getElementById('title-form');
let cancel = document.getElementById('cancel');
let apiNameInput = document.getElementById('apiName');
let urlInput = document.getElementById('url');
let idInput = document.getElementById('idInput');
let table = document.getElementById('api-table');

apiForm.addEventListener('submit', function (event) {
    event.preventDefault();

    let data = {
        api_name: apiNameInput.value,
        url: urlInput.value
    };

    if (idInput.value !== '') {
        method = 'PUT';
        data.id = idInput.value;
    } else {
        method = 'POST';
    }

    fetch('fetch_operations.php', {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('There was an error. The record could not be inserted.');
            }
            return response.json();
        })
        .then(data => {
            updateTable(data);
            Swal.fire({
                title: "Good job!",
                text: "Data saved correctly!",
                icon: "success"
              });

            clear();
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error while processing the request',
                text: error.message
            });
        });
});

function updateTable(data) {
    let tbody = table.querySelector('tbody');
    tbody.innerHTML = '';

    data.forEach(row => {
        var newRow = `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.api_name}</td>
                            <td>${row.url}</td>
                            <td><a href="#" class="btn btn-secondary" onclick="editApi(${row.id})">
                                    <i class="fas fa-marker"></i>
                                </a>
                                <a href="#" class="btn btn-danger" onclick="deleteApi(${row.id})">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    `;
        tbody.innerHTML += newRow;
    });
};

function deleteApi(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('fetch_operations.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('There was an error. The record could not be deleted.');
                    }
                    return response.json();
                })
                .then(data => {
                    updateTable(data);
                    clear();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your data has been deleted.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error while processing the request',
                        text: error.message
                    });
                });
        }
    });
}

function editApi(id) {
    title.innerHTML = "Edit Api";
    cancel.classList.remove('d-none');

    fetch(`fetch_operations.php?id=${id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('There was an error. The record could not be retrieved.');
            }
            return response.json();
        })
        .then(data => {
            apiNameInput.value = data.api_name;
            urlInput.value = data.url;
            idInput.value = data.id;
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error while processing the request',
                text: error.message
            });
        });
}

function cancelEdit() {
    clear();
}

function clear(){
    title.innerHTML = "Insert Api";
    cancel.classList.add('d-none');
    apiNameInput.value = '';
    urlInput.value = '';
    idInput.value = '';
}