<html>
    <head>
        <title>Sports Park</title>
        <meta charset="utf-8">
        <style>
            * {
                box-sizing: border-box;
            }
            body { 
                font-family: Arial, sans-serif;
                margin: 0;
            }
            
            header {
                background: url('headerimage.jpg') center no-repeat;
                background-size: cover;
                /*background-color: lightseagreen;*/
                padding: 40px;

                text-align: center;
                font-size: 70px;
                color: white;
                font-weight: bold;
                text-shadow: 10px 2px lightseagreen;
            }
            .navbar {
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                list-style-type: none;
                background-color: lightgray;
                overflow: hidden;
            }

            .navbaritem {
                float: left;

            }
            li a {
                display: block;
                color: black;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }
            li a:hover {
                background-color: gray;
            }
            
            li a:hover:is(.active) {
                background-color: #1c9993;
            }
            .active {
                background-color: lightseagreen;
            }

            /* styling for text boxes to look neater and follow theme of website */
            input[type=text], input[type=password] {
                border: none;
                border-bottom: 2px solid lightseagreen;
            }
            /* styling for submit button */
            input[type=submit]{
                background-color: lightseagreen;
                border: none;
                padding: 5px;
                margin: 5px;
            }
        </style>
    </head>
<body>
    <!-- same header, navbar, and styling as other pages -->
    <header>
        Sports Park
        <div style="text-shadow: none; font-size: 12px; color: white;">
            Photo by 
            <a href="https://unsplash.com/ja/@dncerullo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" style="color: inherit">Danielle Cerullo</a> 
            on <a href="https://unsplash.com/photos/CQfNt66ttZM?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" style="color: inherit">Unsplash</a>
        </div>
    </header>
    
    <nav>
        <ul class="navbar">
            <li class="navbaritem">
                <a href="index.php">
                    view upcoming classes
                </a>
            </li>
            <li class="navbaritem">
                <a class="active" href="register.php">
                    register new member
                </a>
            </li>
            <li class="navbaritem">
                <a href="manage-membership.php">
                    manage current membership
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- form to enter information for registering new member -->
    <div style="padding: 2px 20px">
        <form method="post">
            Email Address:<input type="text" name="email"> (required) <br>
            Password: <input type="password" name="pass1"> (required) <br>
            Confirm Password: <input type="password" name="pass2"><br>
            <br>
            First Name: <input type="text" name="fname"> (required) <br>
            Last Name: <input type="text" name="lname"> (required) <br>
            Date of Birth: <input type="date" name="dob"><br>
            <br>
            <input type="submit" name="submit" value = "Register"><br>
        </form>
    </div>
    

    <?php
        require 'db_connect.php';
        
        // runs if the form was submitted
        if (isset($_POST["email"], $_POST["pass1"], $_POST["fname"], $_POST["lname"])) {
            // checks if any required information is null
            if ($_POST["email"] == "" || $_POST["pass1"] == "" || $_POST["pass2"] == "" || $_POST["fname"] == "" || $_POST["lname"] == "") {
                echo 'please fill out all required fields.';
            } else {
                // checks for valid email address with regular expression
                if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    // checks the password is the same in both fields
                    if ($_POST['pass1'] == $_POST['pass2']) {
                        // makes variable to add to query based on wether field was left empty or filled out
                        if ($_POST['dob'] == null) {
                            $dob = 'NULL, "'; //null, "\\
                        } else {
                            $dob = '"' . $_POST["dob"] . '", "' ; //"nnnn-nn-nn", "\\
                        }

                        // boolean to see if statement works, random number for User_ID
                        $insertcomplete = False;
                        $randomid = random_int(1000, 1999);

                        do {
                            // built statement using submitted values
                            $insert = 'insert into user values (';
                            $insert .= $randomid . ', "';
                            $insert .= $_POST["fname"] . '", "';
                            $insert .= $_POST["lname"] . '", ';
                            $insert .= $dob;
                            $insert .= $_POST["email"] . '", "';
                            $insert .= $_POST["pass1"] . '", "MEM");';
                            
                            if (mysqli_query($conn, $insert) == true) {
                                $insertcomplete = True;
                                $sql = 'insert into member values (' . $randomid . ', null);';
                                mysqli_query($conn, $sql);
                            } else {
                                // if statement did not work, get a new number and try again
                                $insertcomplete = False;
                                $randomid = random_int(1000, 1999);
                                echo 'retrying insert';
                            }
                        } while ($insertcomplete == False);
                        
                        echo 'Successfully registered to the Sports Park.';

                    } else {
                        echo 'Passwords do not match';
                    }

                } else {
                    echo 'Email address is invalid.';
                }
            }
        }
        // close connection
        mysqli_close($conn);
    ?>

</body>
</html>