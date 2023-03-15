<?php
require 'config.php';
$id = $_GET['id'];
$nameErr = $emailErr = $messageErr = "";

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $audit = true;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $audit = false;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $audit = false;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $audit = false;
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $audit = false;
        }
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
        $audit = false;
    } else {
        $message = $_POST["message"];

        if (strlen($message) < 10) {
            $messageErr = "The message must be longer than two characters";
            $audit = false;
        }
    }

    if ($audit) {
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
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update comment</title>

    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="bg-primary">
    <div class="container pt-4">
        <h1 class="text-white">Update comment</h1>
        <form method="post">
            <p><span class="error text-dark font-weight-bold">* required field</span></p>

            <div>
                <label for="name" class="text-white">Name:</label>
                <span class="error text-dark font-weight-bold">* <?php echo $nameErr; ?></span>
                <input type="text" class="form-control" style="width: 15em;" name="name" value="<?php echo $name; ?>" require>
            </div>

            <div class="pt-3">
                <label for="email" class="text-white">Email:</label>
                <span class="error text-dark font-weight-bold">* <?php echo $emailErr; ?></span>
                <input type="email" class="form-control" style="width: 15em;" name="email" value="<?php echo $email; ?>" require>
            </div>

            <label for="issue" class="pt-3 text-white">Issue:</label>
            <select name="issue" class="form-control" style="width: 15em;">
                <option <?php if ($issue == "Query") echo "selected" ?>>Query</option>
                <option <?php if ($issue == "Feedback") echo "selected" ?>>Feedback</option>
                <option <?php if ($issue == "Complaint") echo "selected" ?>>Complaint</option>
                <option <?php if ($issue == "Other") echo "selected" ?>>Other</option>
            </select>

            <div class="pt-3">
                <span for="message" class="text-white">Message:</span>
                <span class="error text-dark font-weight-bold">* <?php echo $messageErr; ?></span>
                <textarea name="message"><?php echo $message ?></textarea>
            </div>

            <div class="pt-3">
                <input type="submit" name="submit" class="btn btn-light text-primary" value="Submit">
                <a href="/simple-web-contact-form/" class="btn btn-light text-primary">Back</a>
            </div>

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