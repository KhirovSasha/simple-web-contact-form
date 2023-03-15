<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="bg-primary">
    <div class="container pt-4">
        <h1 class="text-white">Commends</h1>
        <h6><a href="create.php" class="btn btn-light text-primary">Add Commend</a></h6>
        <div class="row">
            <div class="col-14">
                <div class="mx-auto" style="width: 50%;">
                    <?php
                    require 'config.php';

                    $result = mysqli_query($con, "SELECT * FROM `comments`");

                    if (mysqli_num_rows($result) > 0) {
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $color;
                            
                            switch($row['issue']){
                                case 'Query':
                                    $color = 'brown';
                                    break;
                                case 'Feedback':
                                    $color = 'indigo';
                                    break;
                                case 'Complaint':
                                    $color = '#74992e';
                                    break;
                                default:
                                    $color = 'black';
                            };

                            echo '<div class="toast show mt-3 mb-4 ">
                                    <div class="toast-header">
                                        <div class="me-1" style="width: 1.5em; height: 1.5em; background-color:'.$color.';"></div>
                                        <strong class="me-auto text-primary">'. $row["name"].'</strong>
                                        <small class="text-muted ms-1 me-2">'.$row['issue'].'</small>
                                        <small><a class="text-decoration-none text-primary" href="update.php?id='.$row['id'].'">Update</a></small>
                                        <a type="button" class="btn-close" href="delete.php?id='.$row['id'].'"></a>
                                    </div>
                                    <div class="toast-body">
                                        '.$row['message'].'
                                    </div>
                                    </div>';
                        }
                    } else {
                        echo "No objects found";
                    }

                    mysqli_close($con);
                    ?>


                    
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>