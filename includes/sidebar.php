<style>

.active {
  background-color: black;
}

body {
  margin: 0;
  height: 80%;
}

.container {
  display: flex;
}

.sidebar {
  width: 150px;
  height: 92vh;
  background-color: pink;
  padding-top: 10px;
  margin-top: 0;
  margin-left: 0;
  /* Other sidebar styles go here */
}

.main-content {
  flex: 1;
  height: 90vh;
  /* Other main content styles go here */
}


.sidebar ul {
  list-style: none;
  padding: 0;
  margin-top 10px;
}

.sidebar li {
  padding-top: 10px;
  margin-bottom: 10px;
  padding-left: 10px;
}

.sidebar a {
  text-decoration: none;
  color: black;
  font-weight: bold;
  font-size: 16px;
  
}

.dashboard-header {
  background-color: lightblue;
  margin-bottom: 0;
  padding-left: 10px;
}

.main-content {
  margin-left: 10px;
}


</style>

<!DOCTYPE html>
<html>
  <head>
    <title>My Sidebar</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1 class="dashboard-header">NEW ZION DASHBOARD</h1>
    <div class="container">
      <div class="sidebar">
  <ul>
    <li><a href="#">Add-Customer</a></li>
    <li><a href="#">Search Customer</a></li>
    <li><a href="#">Products</a></li>
    <li><a href="#">Update Customer</a></li>
  </ul>
</div>