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

            /* styles log in form to match rest of website theme */
            .logintext {
                border: none;
                border-bottom: 2px solid lightseagreen;
            }
            
            .loginbutton{
                background-color: lightseagreen;
                border: none;
                padding: 5px;
                margin: 5px;
            }
        </style>
    </head>
<body>
    <!-- same header and navigation bar as other pages in site -->
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
                <a href="register.php">
                    register new member
                </a>
            </li>
            <li class="navbaritem">
                <a class="active" href="manage-membership.php">
                    manage current membership
                </a>
            </li>
        </ul>
    </nav>

    <div style="padding: 2px 20px">
        <!-- form for entering account details and choosing new membership level -->
        <form method="post">
            Membership level:
            <select id="membershiplevel" name="membershiplevel" >
                <!-- empty value by default to see if form was fully filled out, cannot manually be chosen by user -->
                <option value="" selected disabled hidden> Select an option: </option>
                <option value="Standard"> Standard (free) </option>
                <option value="Silver"> Silver (£24 per month) </option>
                <option value="Gold"> Gold (£30 per month) </option>
            </select><br>
            <label for="email">Email Address: </label> <input class="logintext" type="text" name="email" id="email" value=""><br>
            <label for="password">Password: &emsp;&emsp;</label><input class="logintext" type="password" id="password" name="password" value=""><br>
            <input type="submit" name="Log In" value="submit" class="loginbutton">
        </form>

        <?php
            require "db_connect.php";
            
            // runs if the form was submitted and membership level was not left empty
            if (isset($_POST["email"]) && $_POST["email"] !== "" && $_POST["membershiplevel"] !== "") {
                
                // sees if given email is registered in database
                $sql = 'select user_id from user where email_address = "' . $_POST["email"] . '";';
                $result = mysqli_query($conn, $sql);

                // runs if there is an account associated with email address
                if (mysqli_num_rows($result) == 1) {

                    $sql = 'select _Password, user_id from user where email_address = "' . $_POST["email"] . '";';
                    $rpassword = mysqli_query($conn, $sql);
                    
                    // gets User_ID to use later
                     while ($row = mysqli_fetch_assoc($rpassword)) {
                        $userid = $row["user_id"];

                        // checks password was correct
                        if ($_POST["password"] == $row['_Password']) {

                            $sql = 'select membership_level from member where user_id = "' . $userid . '";';
                            $rlevel = mysqli_query($conn, $sql);

                            $newvalue = $_POST["membershiplevel"];

                            // checks the same membership level was not chosen
                            while ($row = mysqli_fetch_assoc($rlevel)) {
                                $oldvalue = $row['membership_level'];
                                if ($newvalue == $oldvalue) {
                                    echo 'Your membership is already set to this level.';
                                } else {

                                    // makes update and confirm if it works
                                    $update = "update member set membership_level = '" . $newvalue . "' where user_id = " . $userid . ";";
                                    if (mysqli_query($conn, $update) == true) {
                                        echo 'Membership Level updated successfully.';
                                    } else {
                                        echo 'Unable to update database.';
                                    }
                                }
                            }

                            

                            
                        } else {
                            echo 'Incorrect password submitted.';
                        }
                     }
                    
                } else {
                    echo 'This email is not registered with the Sports Park.';
                }
            } else {
                // default message when form is not submitted
                echo 'Use this form to change the membership level associated with your account.';
            }
            // close connection
            mysqli_close($conn);
        ?>

    </div>
    </body>
</html>