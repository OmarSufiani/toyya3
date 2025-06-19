
<?php

?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        color: #333;
        padding: 10px; /* Add some padding around the body */
    }

    .container {
        height: 60px;
            background-color: teal;;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
            margin: 0px;
    }

    .logo h1 {
        font-size: 2.5rem;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: bold;
        margin-left: 20px;
    }

    nav ul {
        list-style-type: none;
        display: flex;
        margin-right: 20px;
    }

    nav ul li {
        margin-left: 30px;
    }

    nav ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 1.1rem;
        text-transform: uppercase;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    nav ul li a:hover {
        color: #FFD700;
        transform: scale(1.1);
    }

    @media screen and (max-width: 768px) {
        .container {
            flex-direction: column;
            text-align: center;
        }

        nav ul {
            margin-top: 20px;
            flex-direction: column;
        }

        nav ul li {
            margin: 10px 0;
        }

        .logo h1 {
            margin-left: 0;
        }
    }
</style>

<div class="container">
    <div class="logo">
        <h1>FIKRATUL JANNAH</h1>
    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</div>
