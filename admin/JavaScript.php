<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BABE</title>
    <script src="script.js"></script>

    <style>
        body {
            background-color: lightviolet;
            background-image: url('https://www.example.com/heart.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        h2,
        p {
            text-align: center;
            font-family: sans-serif;
            color: #ff69b4;
        }

        .love-button {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .love-box {
            border: 1px solid black;
            width: 50%;
            justify-content: center;
            align-items: center;
            margin: auto;
            padding: 20px;
            background-image: ("C:\Users\Keith\OneDrive\Pictures\Camera Roll\WIN_20221111_21_43_57_Pro.jpg");
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sweet-message {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 1.2em;
            color: #ff69b4;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <div class="love-box">
        <h2>Love Language</h2>
        <p id="test">Hey Babe</p>
        <p id="sweet-message" class="sweet-message"></p>
        <input type="text" id="inputbox">

        <button onclick="myFunction1()" class="love-button">Click Me</button>
    </div>

</body>
<script>
    function myFunction() {
        document.getElementById("test").innerHTML = "I Love You";
        
    }
</script>
<script>
    function myFunction1() {
        if (document.getElementById("inputbox").value == 'Hey Babe') {
            document.getElementById("test").style.color = "red";

            return(test);
        } else {
            document.getElementById("sweet-message").innerHTML = "I love you always and forever";
            alert("I Love You");
        }
    }
</script>

</html>