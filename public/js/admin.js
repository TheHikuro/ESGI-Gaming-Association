
(async () => {
    await getUsers()
})();

async function getUsers() {
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

    const formatedHeader = ['Nom', 'Prénom', 'Email', 'Pseudo', 'Section', 'Rôles', 'Actions']
    document.querySelector('#userList thead tr').innerHTML = formatedHeader.map(item => {
        return (
            `<th class='text-center border h-10'>${item}</th>`
        )
    }).join('')

    const formatedUsers = users.map(user => {
        return (`<tr class='h-20'>
                    <td class='border text-center'>${user.name}</td>
                    <td class='border text-center'>${user.lastname}</td>
                    <td class='border text-center'>${user.email}</td>
                    <td class='border text-center'>${user.pseudo}</td>
                    <td class='border text-center'>${user.section.name}</td>
                    <td class='border text-center'>${user.roles[0]}</td>
                    <td class='border text-center items-center'>
                        <div class='flex justify-evenly items-center w-full'>
                            <button class="w-10 h-5" onclick="editUser(${user.id})">Edit</button>
                            <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="deleteUser(${user.id})">Delete</button>
                        </div>
                    </td>
                </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedUsers.join('')
}

async function getSections() {
    const sections = await fetch(`${api_section}find?showJson=1&populate=id,name`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            return data.data
        })

    const formatedHeader = ['Id', 'Nom', 'Actions']

    document.querySelector('#userList thead tr').innerHTML = formatedHeader.map(item => {
        return (
            `<th class='text-center border h-10'>${item}</th>`
        )
    }).join('')

    const formatedSections = sections.map(section => {
        return (`<tr class='h-10'>
        <td class='border text-center'>${section.id}</td>
        <td class='border text-center'>${section.name}</td>
        <td class='border text-center items-center'>
            <div class='flex justify-evenly items-center w-full'>
                <button class="w-10 h-5" onclick="editSection(${section.id})">Edit</button>
                <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="deleteSection(${section.id})">Delete</button>
            </div>
        </td>
    </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedSections.join('')
}

async function getAssos() {
    const assos = await fetch(`${api_asso}find?showJson=1&populate=id,name`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            return data.data
        })

    const formatedHeader = ['Id', 'Nom', 'Actions']

    document.querySelector('#userList thead tr').innerHTML = formatedHeader.map(item => {
        return (
            `<th class='text-center border h-10'>${item}</th>`
        )
    }).join('')

    const formatedAssos = assos.map(asso => {
        return (`<tr class='h-10'>
        <td class='border text-center'>${asso.id}</td>
        <td class='border text-center'>${asso.name}</td>
        <td class='border text-center items-center'>
            <div class='flex justify-evenly items-center w-full'>
                <button class="w-10 h-5" onclick="editAsso(${asso.id})">Edit</button>
                <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="deleteAsso(${asso.id})">Delete</button>
            </div>
        </td>
    </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedAssos.join('')
}

// create modal for edit btn 
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
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="text" placeholder="Section" value="${users.find(user => user.id == id).section}">
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



document.getElementById('contBtnDashboard').addEventListener('click', async (e) => {
    if (e.target.tagName === 'BUTTON') {
        switch (e.target.name) {
            case 'btnUsers':
                await getUsers()
                break
            case 'btnSections':
                await getSections()
                break
            case 'btnAssos':
                await getAssos()
                break
            case 'btnMailer':
                await getMailer()
                break
            default:
                await getUsers()
                break
        }
    }
}
)
