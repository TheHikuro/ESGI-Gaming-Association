
async function editUser(id) {
    const modal = document.querySelector('#modal')
    modal.classList.add('flex')
    modal.classList.remove('hidden')
    const users = await fetch(`${api_user}find?showJson=1&populate=id,name,lastname,email,pseudo,section{name},roles`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            return data.data
        })
    modal.innerHTML = `
        <div class="w-4/6 bg-white mx-auto my-auto rounded shadow-lg z-50">
            <div class="flex justify-between p-4 border-b">
                <h3 class="text-2xl font-bold">Modifier un utilisateur</h3>
                <button class="top-0 right-0 m-4 text-3xl" onclick='closeModal()'>&times;</button>
            </div>
            <div class="p-4">
                <form class="w-full" id="editUserForm">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                Nom
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" type="text" placeholder="Nom" value="${users.find(user => user.id == id).name}">
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Prénom
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Prénom" value="${users.find(user => user.id == id).lastname}">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                Email
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="email" placeholder="Email" value="${users.find(user => user.id == id).email}">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                Pseudo
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="Pseudo" value="${users.find(user => user.id == id).pseudo}">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                Section
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="Section" value="${users.find(user => user.id == id).section.name}">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                Rôles
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="Rôles" value="${users.find(user => user.id == id).roles}">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick='closeModal()'>
                                Annuler
                            </button>
                        <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick='saveUser(${id})'> 
                            Enregistrer 
                        </button>
                    </div>
                </form>
            </div>
        </div>
        `
}

function modalDelete(id) {
    const modal = document.querySelector('#modal')
    modal.classList.add('flex')
    modal.classList.remove('hidden')
    // make yes no modal appear using tailwind
    modal.innerHTML = `
        <div class="w-full h-full bg-gray-900 opacity-50"></div>
        <div class="mx-auto my-auto w-11/12 md:max-w-md bg-white rounded shadow-lg z-50 overflow-y-auto">
            <div class="py-4 text-left px-6">
                <div>
                    Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                </div>
                <div class="flex justify-end">
                    <button class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick='closeModal()'>
                            Annuler
                        </button>
                    <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick='deleteUser(${id})'>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
        `
}

function saveUser(id) {
    let form = document.getElementById('editUserForm')
    let formData = new FormData(form)
    fetch(`http://localhost:3000/user/edit/${id}`, {
        method: 'PUT',
        body: formData
    }).then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                closeModal()
                getUsers()
            }
        })
}

function deleteUser(id) {
    fetch(`http://localhost:3000/user/delete/${id}`, {
        method: 'DELETE'
    }).then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                closeModal()
                getUsers()
            }
        })
}