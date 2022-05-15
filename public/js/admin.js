
(async () => {
    await getUsers()
})();

async function getUsers() {
    document.querySelector('#userList').classList.remove('hidden')
    document.querySelector('#mailer').classList.add('hidden')
    document.getElementById('title').innerHTML = 'Utilisateurs'
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
                            <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="modalDelete(${user.id})">Delete</button>
                        </div>
                    </td>
                </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedUsers.join('')
}

async function getSections() {
    document.querySelector('#userList').classList.remove('hidden')
    document.querySelector('#mailer').classList.add('hidden')
    document.getElementById('title').innerHTML = 'Sections'
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
                <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="modalDelete(${section.id})">Delete</button>
            </div>
        </td>
    </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedSections.join('')
}

async function getAssos() {
    document.getElementById('title').innerHTML = 'Associations'
    document.querySelector('#userList').classList.remove('hidden')
    document.querySelector('#mailer').classList.add('hidden')
    const assos = await fetch(`${api_asso}find?showJson=1&populate=id,name,members{id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(response => response.json())
        .then(data => {
            return data.data
        })

    const formatedHeader = ['Id', 'Nom', 'Nombre de membre', 'Actions']

    document.querySelector('#userList thead tr').innerHTML = formatedHeader.map(item => {
        return (
            `<th class='text-center border h-10'>${item}</th>`
        )
    }).join('')

    const formatedAssos = assos.map(asso => {
        console.log(asso);
        return (`<tr class='h-10'>
        <td class='border text-center'>${asso.id}</td>
        <td class='border text-center'>${asso.name}</td>
        <td class='border text-center'>${asso.members.length}</td>
        <td class='border text-center items-center'>
            <div class='flex justify-evenly items-center w-full'>
                <button class="w-10 h-5" onclick="editAsso(${asso.id})">Edit</button>
                <button class="flex justify-center items-center p-3 rounded-md bg-red-500 hover:bg-red-700 h-7" onclick="modalDelete(${asso.id})">Delete</button>
            </div>
        </td>
    </tr>`)
    })
    document.querySelector('#userList tbody').innerHTML = formatedAssos.join('')
}

function getMailer() {
    document.getElementById('title').innerHTML = 'Boite Mail'
    document.querySelector('#userList').classList.add('hidden')
    document.querySelector('#mailer').classList.remove('hidden')
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
                getMailer()
                break
            default:
                await getUsers()
                break
        }
    }
}
)
