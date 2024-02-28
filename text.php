<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="box">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="text" name="itemCatogoryName" class="inputBox">

                <select name="item" id="options" class="inputBox">
                    <option value=""></option>
                    <?php
                    $server = 'localhost';
                    $username = 'root';
                    $password = '';
                    $dbname = 'category';
                    $conn = mysqli_connect($server, $username, $password, $dbname);
                    if (!$conn) {
                        die('Connection failed: ' . mysqli_connect_error());
                    }
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $itemCatogory = $_POST['itemCatogoryName'];
                        $item = $_POST['item'];
                        if ($item == '') {
                            $sql = "INSERT INTO itemcategory (name) VALUES ('$itemCatogory')";
                            $result = mysqli_query($conn, $sql);
                        }
                        if ($item != '') {
                            $sql = "INSERT INTO items (categoryId, itemName) VALUES ('$item','$itemCatogory')";
                            $result = mysqli_query($conn, $sql);
                        }
                    }
                    $selectQuery = "SELECT * FROM itemcategory";
                    $selectResult = mysqli_query($conn, $selectQuery);
                    if (mysqli_num_rows($selectResult) > 0) {
                        while ($row = mysqli_fetch_assoc($selectResult)) {
                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                    }

                    ?>
                </select>
                <button type="submit" value="Submit" class="btn">Submit</button>
            </form>
        </div>

        <div class="details">
            <?php
            $server = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'category';
            $conn = mysqli_connect($server, $username, $password, $dbname);
            if (!$conn) {
                die('Connection failed: ' . mysqli_connect_error());
            }
            $selectQuery = "SELECT * FROM itemcategory";
            $selectResult = mysqli_query($conn, $selectQuery);
            if (mysqli_num_rows($selectResult) > 0) {
                echo '<ul>';
                while ($row = mysqli_fetch_assoc($selectResult)) {
                    echo "<li> ";
                    echo $row['name'];
                    $name = $row['name'];
                    $sq = "SELECT * FROM items WHERE categoryId = (SELECT name FROM itemcategory WHERE name = '$name')";
                    $res = mysqli_query($conn, $sq);
                    if (mysqli_num_rows($res) > 0) {
                        echo "<ul style='position:relative;left:25px'>";
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<li>" . $row['itemName'] . "</li>";
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "No data found";
            }
            ?>
        </div>
    </div>
</body>

</html>