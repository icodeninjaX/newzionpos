<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {

            background-color: #4a69bd;
        }

        .navbar .nav-item .nav-link {
            color: black;
        }

        .navbar .nav-item .nav-link:hover {
            color: lightgray;
        }

        .navbar-brand {
            color: #fff;
        }

        .navbar-brand:hover {
            color: #f1c40f;
        }

        .container {
            max-width: 100%;

        }

        .order-form {
            width: 50%;
            background-color: white;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 1rem;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .order-form h2 {
            font-size: 1.75rem;
            border-bottom: 1px solid #ced4da;

        }

        .order-form label,
        .order-form input,
        .order-form select {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .order-form input[type="submit"] {
            background-color: #4a69bd;
            color: #fff;
            border: none;
            height: 40px;
            width: 120px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .order-form input[type="submit"]:hover {
            background-color: #6c7ae0;
        }

        .item-row {
            font-size: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: stretch;
            background-color: #f8f9fa;
            border-radius: 5px;
            position: relative;
        }

        .total-row {
            margin-top: 20px;
        }

        .item-row button {
            position: absolute;
            right: 0;
        }

        .item-row label {
            flex: 1;
            margin-bottom: 0;
        }

        .item-row select,
        .item-row input {
            flex: 2;
            margin-left: 1rem;
        }

        .remove_item_btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
            margin-left: 100px;
        }

        .remove_item_btn:hover {
            background-color: #c0392b;
        }

        #add_item_btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #add_item_btn:hover {
            background-color: #218838;
        }

        .alert {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        input[type="number"]:focus,
        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #4a69bd;
            box-shadow: 0 0 0 0.2rem rgba(74, 105, 189, 0.25);
        }

        .material-icons {
            margin-right: 8px;
            color: #4CAF50;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">New Zion POS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search-customer.php">Search</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="order-form">
            <?php
            if (isset($_SESSION['order_success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['order_success'] . "</div>";
                unset($_SESSION['order_success']);
            }


            ?>
            <h2><i class="material-icons">shopping_cart</i>Place Order</h2>
            <?php

            if (isset($_GET['id'])) {
                $customer_id = $_GET['id'];
                ?>

                <form action="order-received.php" method="post">
                    <p style="font-size: 15px; font-weight: bold;">Customer ID:
                        <?php echo $customer_id; ?>
                    </p>

                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                    <div class="item_row">
                        <div class="item-row">
                            <label for="product_name" style="font-size: 20px; font-weight: bold;">Select product</label>
                            <select name="product_name[]" class="product_name"
                                style="height: 35px; font-size: 12px; font-weight: bold;">
                                <?php
                                // Connect to the database
                                require_once 'db_connection.php';

                                // Prepare the SQL statement
                                $stmt = mysqli_prepare($conn, "SELECT product_id, product_name, price FROM products");

                                // Execute the statement
                                mysqli_stmt_execute($stmt);

                                // Bind the result variables
                                mysqli_stmt_bind_result($stmt, $id, $product_name, $price);

                                // Fetch the results
                                echo "<option value='' selected>Select Product</option>";

                                while (mysqli_stmt_fetch($stmt)) {
                                    echo "<option value='{$product_name}|{$price}' data-price='{$price}'>{$product_name}  {$price}</option>";
                                }

                                // Close the statement and connection
                                mysqli_stmt_close($stmt);
                                ?>
                            </select>
                        </div>
                        <div class="item-row">
                            <label for="quantity" style="font-size: 20px; font-weight: bold;">Quantity:</label>
                            <input type="number" name="quantity[]" class="quantity" value="1" required
                                style="height: 35px; font-size: 12px; font-weight: bold;">
                        </div>
                        <button class="remove_item_btn" type="button">Remove Item</button>

                    </div>
                    <button id="add_item_btn" type="button">Add Item</button>
                    <br>
                    <div class="item-row total-row">
                        <label for="total_price" style="font-size: 20px; font-weight: bold;">Total Price:</label>
                        <input type="number" name="total_price" id="total_price" step="0.01" readonly
                            style="height: 35px; font-size: 12px; font-weight: bold;">
                        <br>
                    </div>
                    <?php
                    $branch_query = "SELECT id, branch_name, contact_number FROM branches";
                    $branch_result = mysqli_query($conn, $branch_query);
                    if ($branch_result) {
                        ?>
                        <div class="item-row">
                            <label for="branch" style="font-size: 20px; font-weight: bold;">Branch:</label>
                            <select id="branch-selector" name="branch"
                                style="height: 35px; font-size: 12px; font-weight: bold;">
                                <?php
                                while ($branch_row = mysqli_fetch_assoc($branch_result)) {
                                    $branch_id = $branch_row['id'];
                                    $branch_name = $branch_row['branch_name'];
                                    $contact_number = $branch_row['contact_number'];
                                    echo "<option value='{$branch_id}' data-contact-number='{$contact_number}'>{$branch_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                    mysqli_close($conn);
                    ?>
                    </select>
                    <div class="item-row">
                        <label for="cashier" style="font-size: 20px; font-weight: bold;">Cashier:</label>
                        <input type="text" name="cashier" id="cashier" value="<?php echo $_SESSION['username']; ?>" readonly
                            style="height: 35px; font-size: 12px; font-weight: bold;">
                    </div>

                    <div class="item-row">
                        <label for="remarks" style="font-size: 20px; font-weight: bold;">Remarks:</label>
                        <input type="text" name="remarks" id="remarks"
                            style="height: 35px; font-size: 12px; font-weight: bold;">
                    </div>
                    <input type="hidden" name="branch_phone_number" value="">

                    <input type="submit" name="submit" value="Add Order">
                </form>
                <?php
            } else {
                echo "<p>Invalid request. Please try again.</p>";
            }
            ?>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/1xtqVMRAxVzJ3O59nDubBcYa7SwDsi9pX1Gp7D"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-gzjHzU5l3r9X7t7YNS8xiW45d2RZt    4Dxjx7fW8eKs7sTzFt4h17nUpckHtS4z7gXqbcNmjz7W3K0783"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMm6lMapl"
        crossorigin="anonymous"></script>
    <script>
        const priceInput = document.getElementById("total_price");

        function updatePrice() {
            let totalPrice = 0;
            const itemRows = document.getElementsByClassName("item_row");
            for (let i = 0; i < itemRows.length; i++) {
                const productSelect = itemRows[i].querySelector(".product_name");
                const quantityInput = itemRows[i].querySelector(".quantity");

                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute("data-price"));
                const quantity = parseInt(quantityInput.value, 10) || 0;

                totalPrice += price * quantity;
            }
            priceInput.value = totalPrice.toFixed(2);
        }

        const addItemBtn = document.getElementById("add_item_btn");
        addItemBtn.addEventListener("click", () => {
            const itemRows = document.getElementsByClassName("item_row");
            const lastItemRow = itemRows[itemRows.length - 1];

            // Remove the existing remove button before cloning
            const existingRemoveButton = lastItemRow.querySelector(".remove_item_btn");
            existingRemoveButton.remove();

            const newItemRow = lastItemRow.cloneNode(true);

            // Re-add the remove button to the last item row
            lastItemRow.appendChild(existingRemoveButton);

            newItemRow.querySelector(".quantity").value = "1";

            const newProductSelect = newItemRow.querySelector(".product_name");
            const newQuantityInput = newItemRow.querySelector(".quantity");
            newProductSelect.addEventListener("change", updatePrice);
            newQuantityInput.addEventListener("input", updatePrice);

            const removeItemBtn = document.createElement("button");
            removeItemBtn.textContent = "Remove Item";
            removeItemBtn.classList.add("remove_item_btn");
            removeItemBtn.addEventListener("click", () => {
                newItemRow.remove();
                updatePrice();
            });

            newItemRow.appendChild(removeItemBtn);
            lastItemRow.parentNode.insertBefore(newItemRow, addItemBtn);
        });

        const firstItemRow = document.querySelector(".item_row");
        const firstProductSelect = firstItemRow.querySelector(".product_name");
        const firstQuantityInput = firstItemRow.querySelector(".quantity");
        firstProductSelect.addEventListener("change", updatePrice);
        firstQuantityInput.addEventListener("input", updatePrice);

        updatePrice();


        document.addEventListener('DOMContentLoaded', function () {
            const branchSelector = document.getElementById('branch-selector');
            branchSelector.addEventListener('change', function () {
                const selectedOption = branchSelector.options[branchSelector.selectedIndex];
                const contactNumber = selectedOption.getAttribute('data-contact-number');

                // Set the value of the hidden input field with the name 'branch_phone_number'
                const branchPhoneNumberInput = document.querySelector("input[name='branch_phone_number']");
                branchPhoneNumberInput.value = contactNumber;
            });
        });
    </script>
</body>

</html>