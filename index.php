<?php
$errors = "";
$db = mysqli_connect("localhost", "root", "", "todolist");
if (isset($_POST['submit'])) {
    if (empty($_POST['Title']) or empty($_POST['Description'])) {
        $errors = "You must fill in the title and description";
    } else {
        $title = $_POST['Title'];
        $description = $_POST['Description'];
        $sql = "INSERT INTO todoitems (Title, Description) VALUES ('$title','$description')";
        mysqli_query($db, $sql);
        header('location: index.php');
    }
}
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    mysqli_query($db, "DELETE FROM todoitems WHERE ItemNum=" . $id);
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>To Do List</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
    <main>
        <h2 class="heading">To Do List</h2>
        <form method="post" action="index.php" class="input_form">
            <input type="text" name="Title" class="task_input" placeholder="Title" size="20">
            <input type="text" name="Description" class="task_input" placeholder="Description" size="50">
            <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th class="title">Title</th>
                    <th class="description">Description</th>
                    <th>Completed?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $todoitems = mysqli_query($db, "SELECT * FROM todoitems");
                $i = 1;
                while ($row = mysqli_fetch_array($todoitems)) { ?>
                    <tr>
                        <td class="title"> <?php echo $row['Title']; ?> </td>
                        <td class="description"> <?php echo $row['Description']; ?> </td>
                        <td class="delete">
                            <a href="index.php?del_task=<?php echo $row['ItemNum'] ?>">&#10003</a>
                        </td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
        <?php if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
        <?php } ?>
    </main>
</body>

</html>