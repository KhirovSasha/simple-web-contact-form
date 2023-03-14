<?php
include "config.php";
$nameErr = $emailErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if(empty($_POST["message"])){
        $messageErr = "Message is required";
    }

}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $issue = $_POST['issue'];
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($message)) {
        mysqli_query($con, "INSERT INTO comments(name, email, issue, message) VALUES('" . $name . "','" . $email . "','" . $issue . "','" . $message . "') ");
        header('location: index.php');
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
    <title>Create comment</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>

<body>

    <div class="container">
        <h1>Send comment</h1>
        <form method='post'>
            <p><span class="error">* required field</span></p>

            <label for="name">Name</label>
            <input type="text" name="name" require>
            <span class="error">* <?php echo $nameErr; ?></span>

            <label for="email">Email</label>
            <input type="email" name="email" require>
            <span class="error">* <?php echo $emailErr;?></span>

            <label for="issue">Issue</label>
            <select name="issue">
                <option>Query</option>
                <option>Feedback</option>
                <option>Complaint</option>
                <option>Other</option>
            </select>

            <textarea id="summernote" name="message" require></textarea>
            <span class="error">* <?php echo $messageErr;?></span>

            <input type="submit" name="submit" value="Submit">
            <a href="/simple-web-contact-form/">Back</a>
        </form>

    </div>



    <script>
        $('#summernote').summernote({
            placeholder: 'Hello Bootstrap 4',
            tabsize: 2,
            height: 100

        });
    </script>
</body>

</html>