<?php
require 'config.php';
$id = $_GET['id'];

if ($id != null) {
    $query = "SELECT * FROM `comments` WHERE id='$id'";

    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $message = $row['message'];
        $name = $row['name'];
        $email = $row['email'];
        $issue = $row['issue'];
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $issue = $_POST['issue'];
    $message = $_POST['message'];


    $sql = "UPDATE comments SET name='$name', email='$email', issue='$issue', message='$message' WHERE id=$id";

    if($con->query($sql) === TRUE){
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.css">
</head>

<body>
    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo $name; ?>" require>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>" require>

        <label for="issue">Issue</label>
        <select name="issue">
            <option <?php if ($issue == "Query") echo "selected" ?>>Query</option>
            <option <?php if ($issue == "Feedback") echo "selected" ?>>Feedback</option>
            <option <?php if ($issue == "Complaint") echo "selected" ?>>Complaint</option>
            <option <?php if ($issue == "Other") echo "selected" ?>>Other</option>
        </select>

        <textarea name="message"><?php echo $message ?></textarea>
        <input type="submit" name="submit" value="Submit">

    </form>

    <script>
        ClassicEditor
            .create(document.querySelector('textarea[name="message"]'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>