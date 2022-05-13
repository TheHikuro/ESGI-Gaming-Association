
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
