<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$price = '';
$description = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');


    if(!$title) {
        $errors[] = 'Product title is required.';
    }

    if(!$price) {
        $errors[] = 'Product price is required.';
    }

    if(empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                        VALUES(:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', '');
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
    
        $statement->execute();
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products CRUD</title>
</head>

<body>
    <h1>Create New Product</h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error):?>
            <div class=""><?=$error;?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <form action="create.php" method="post">
        <div class="form-group">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
        </div>
        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title"><?=$title?></input>
        </div>
        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"><?=$description?></textarea>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" step=".01" class="form-control" name="price"><?=$price?></input>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>