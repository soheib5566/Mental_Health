document.addEventListener("DOMContentLoaded", function () {
    // Dummy data for demonstration
    const data = [];

    // إضافة 100 مستخدم إلى المصفوفة
    // for (let i = 1; i <= 100; i++) {
    //     data.push({ name: "Doctor " + i, Rate: "1/5 " , phone: "Phone " + i, ID: "ID " + i });
    // }

    const tableBody = document.querySelector("#data-table tbody");

    // Function to populate table with data
    function populateTable() {
        tableBody.innerHTML = "";

        data.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.ID}</td>
                <td>${item.name}</td>
                <td>${item.Rate}</td> 
                <td>${item.phone}</td>
                <td>${item.Governorate}</td>
                <td>${item}</td>
                <td>${item}</td>
                <td class="actions">
                    <button class="delete" onclick="deleteItem(${index})">Delete</button>
                    <button class="Edit" onclick="EditItem(${index})">Edit</button> 
                    <button class="Add" onclick="addItem()">Add</button> 
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    populateTable();
    window.deleteItem = function (index) {
        data.splice(index, 1);
        populateTable();
    };
    window.EditItem = function (index) {
        window.location.href = 'Edit.html';
    };
    window.addItem = function () {
        window.location.href = 'Add.html';
    };
});
