
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
        background-color: teal;
    width:100%;
        padding: 20px 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    
        
        border-radius: 12px; /* Rounded corners */
    }

    .logo h1 {
        font-size: 2.5rem;
        color: white;
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
<body>
<div class="container">
    <div class="logo">
        <h1>FIKRATUL JANNAH</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="organize/about.php">About</a></li>
            <li><a href="organize/contact.php">Contact</a></li>
        </ul>
    </nav>
</div>
</body>