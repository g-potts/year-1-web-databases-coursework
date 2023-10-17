<!DOCTYPE html>
<html lang="en">
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
        
        /* formats the header and image used in it */
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


        /* formats the table that shows the result of the query */
        table, th, td {
            border: 1px solid black;
        }

        
        /* all following format the navigation bar */
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

    </style>
</head>
<body>
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
                <a class="active" href="index.php">
                    view upcoming classes
                </a>
            </li>
            <li class="navbaritem">
                <a href="register.php">
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

    <div style="padding: 2px 20px">

        <h3>
            Upcoming Classes:
        </h3>

        <!-- the form to filter results. the name sport[] for all inputs creates an array of selected options. -->
        <form method="get">
            <input type="checkbox" name="sport[]" value="Football"> Football <br>
            <input type="checkbox" name="sport[]" value="Volleyball"> Volleyball <br>
            <input type="checkbox" name="sport[]" value="Basketball"> Basketball <br>
            <input type="checkbox" name="sport[]" value="Rugby"> Rugby <br>
            <input type="checkbox" name="sport[]" value='Water Polo'> Water Polo <br>
            <input type="checkbox" name="sport[]" value="Tennis"> Tennis <br>

            <input type="submit" value="apply filters">
        </form> <br>

        <!-- makes the heading of the table before results are added -->
        <table id="classtable">
            <tr>
                <th>Date</th>
                <th>Sport</th>
                <th>Spaces Booked</th>
                <th>Price</th>
            </tr> 
        
        <?php
            include "db_connect.php";

            // makes base of query
            $sql = "select c._DateTime, c.Sport_Name, c.Spaces_Booked, l.Capacity, c.Price from classes c inner join locations l on c.location_id = l.location_type";

            // adds 'where' clause if needed
            if(!empty($_GET['sport'])) {   
                $sql .= " where ";
                $i = 1;
                foreach($_GET['sport'] as $value){
                    $sql .= 'c.Sport_Name = "' . $value .'"';
                    if ($i < count($_GET['sport'])) {
                        $sql .= ' or ';
                    }
                    $i++;

                }
            }
            $sql .= ";";
            
            $result = mysqli_query($conn, $sql);
            // loops through resulting rows and makes new rows of table through HTML for each result
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['_DateTime']?></td>
                    <td><?php echo $row['Sport_Name']?></td>
                    <td><?php echo $row['Spaces_Booked']?>/<?php echo $row["Capacity"]?></td>
                    <td>£<?php echo $row['Price']?></td>
                </tr>

        <?php } 
            // closes connection
            mysqli_close($conn);
        ?> </table>

    </div>
</body>
</html>