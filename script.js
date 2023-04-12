document.addEventListener("DOMContentLoaded", function () {
  // Add event listener for the add customer button
  document
    .getElementById("add_customer_btn")
    .addEventListener("click", function () {
      var cus_code = document.getElementById("cus_code").value;
      var tel_num = document.getElementById("tel_num").value;
      var first_name = document.getElementById("first_name").value;
      var last_name = document.getElementById("last_name").value;
      var cus_address = document.getElementById("cus_address").value;
      var street = document.getElementById("street").value;
      var subdivision = document.getElementById("subdivision").value;
      var landmark = document.getElementById("landmark").value;
      var remarks = document.getElementById("remarks").value;
      var city = document.getElementById("city").value;
      var branch = document.getElementById("branch").value;

      // Send ajax request to the server to insert customer data into the database
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "add-customer.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          // Handle the response from the server
          console.log(xhr.responseText);
          if (xhr.responseText === "Customer added successfully") {
            alert("Customer added successfully");
          } else {
            alert("The cus_code you entered already exists, try another");
          }
        }
      };
      xhr.send(
        "cus_code=" +
          cus_code +
          "&tel_num=" +
          tel_num +
          "&first_name=" +
          first_name +
          "&last_name=" +
          last_name +
          "&cus_address=" +
          cus_address +
          "&street=" +
          street +
          "&subdivision=" +
          subdivision +
          "&landmark=" +
          landmark +
          "&remarks=" +
          remarks +
          "&city=" +
          city +
          "&branch=" +
          branch
      );
    });
});

async function updateReport() {
  const selectedDate = document.getElementById("reportDate").value;
  const reportType = document.getElementById("reportType").value;
  const reportUrl = `fetch_report.php?date=${selectedDate}&type=${reportType}`;

  try {
    const response = await fetch(reportUrl);
    const data = await response.json();
    displayReportData(data);
  } catch (error) {
    console.error("Error fetching report data:", error);
  }
}

function displayReportData(data) {
  const table = document.createElement("table");
  table.setAttribute("id", "salesReportTable");
  table.innerHTML = `
      <thead>
          <tr>
              <th>Product</th>
              <th>Quantity Sold</th>
              <th>Total Sales</th>
          </tr>
      </thead>
      <tbody>
      ${data
        .map(
          (item) => `
          <tr>
              <td>${item.product}</td>
              <td>${item.quantity}</td>
              <td>${item.total_sales}</td>
          </tr>
      `
        )
        .join("")}
      </tbody>
  `;

  const reportContainer = document.getElementById("reportContainer");
  const existingTable = document.getElementById("salesReportTable");
  if (existingTable) {
    reportContainer.replaceChild(table, existingTable);
  } else {
    reportContainer.appendChild(table);
  }
}
