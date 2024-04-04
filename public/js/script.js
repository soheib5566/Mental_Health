const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});



document.addEventListener("DOMContentLoaded", function () {
    const dashboardLink = document.querySelector("#sidebar .side-menu.top li:nth-child(1) a");
    const dataTables = document.querySelectorAll(".table-data .order");
    dashboardLink.addEventListener('click', function (event) {
        event.preventDefault();
        dataTables.forEach(function (dataTable) {
            dataTable.style.display = 'none';
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const usersLink = document.querySelector("#sidebar .side-menu.top li:nth-child(2) a");
    const dataTable = document.querySelector(".table-data .order");
    usersLink.addEventListener('click', function (event) {
        event.preventDefault();
        dataTable.style.display = 'block';
    });
});




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
})





if (window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
})
// document.addEventListener("DOMContentLoaded", function () {
//     const tbody = document.querySelector(".table-data tbody");

//     for (let i = 0; i < 100; i++) {
//         const id = Math.floor(Math.random() * 1000000);
//         const name = "User " + (i + 1);
//         const phone = "01" + Math.floor(Math.random() * 1000000000);
//         const account = "user" + (i + 1) + "@example.com";

//         const row = document.createElement("tr");
//         const idCell = document.createElement("td");
//         idCell.textContent = id;
//         row.appendChild(idCell);

//         const nameCell = document.createElement("td");
//         nameCell.textContent = name;
//         row.appendChild(nameCell);

//         const phoneCell = document.createElement("td");
//         phoneCell.textContent = phone;
//         row.appendChild(phoneCell);

//         const accountCell = document.createElement("td");
//         accountCell.textContent = account;
//         row.appendChild(accountCell);

//         const actionCell = document.createElement("td");
//         const deleteButton = document.createElement("button");
//         deleteButton.textContent = "Delete";
//         deleteButton.classList.add("status", "pending");
//         deleteButton.onclick = function () {
//             deleteItem(id);
//         };
//         actionCell.appendChild(deleteButton);

//         const blockButton = document.createElement("button");
//         blockButton.textContent = "BLOCK";
//         blockButton.classList.add("status", "completed");
//         blockButton.onclick = function () {
//             blockItem(id);
//         };
//         actionCell.appendChild(blockButton);

//         row.appendChild(actionCell);

//         tbody.appendChild(row);
//     }
// });
// document.addEventListener("DOMContentLoaded", function () {
//     const doctorsTable = document.querySelector(".doctors-table");
//     const usersTable = document.querySelector(".users-table");

//     const doctorsMenuItem = document.querySelector(".side-menu a[href='#'][data-target='doctors']");
//     const usersMenuItem = document.querySelector(".side-menu a[href='#'][data-target='users']");

//     doctorsMenuItem.addEventListener("click", function () {
//         doctorsTable.style.display = "block";
//         usersTable.style.display = "none";
//     });

//     usersMenuItem.addEventListener("click", function () {
//         doctorsTable.style.display = "none";
//         usersTable.style.display = "block";
//     });
// });

function createDoctorsTable() {
    var table = document.createElement('table');
    table.id = 'doctor-table';


    headers.forEach(function (headerText) {
        var th = document.createElement('th');
        th.appendChild(document.createTextNode(headerText));
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);



    table.appendChild(tbody);

}
function redirectToUsersPage() {
    window.location.href = "/users";
}

