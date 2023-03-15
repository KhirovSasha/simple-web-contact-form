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

    if ($con->query($sql) === TRUE) {
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="bg-primary">
    <div class="container pt-4">
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
            <a href="/simple-web-contact-form/">Back</a>
        </form>
    </div>


    <script>
        ClassicEditor
            .create(document.querySelector('textarea[name="message"]'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>