<?php
require_once 'functions.php';
// Import functions.php

try {
    // Get the tiers with the getTiers() function imported from functions.php
   $tiers = getTiers();
   
} catch (Exception $e) {
    // If an error is thrown, echo the message
    echo $e->getMessage();
}

?>

<?php require_once '_header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Home</a>
<a href='members.php' class='btn btn-secondary m-2 active' role='button'>Members</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
<div class='row'>
    <div class='alert alert-success'>
        Success! <?= $_GET['message'] ?>
    </div>
</div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
<div class='row'>
    <div class='alert alert-danger'>
        Error! <?= $_GET['message'] ?>
    </div>
</div>
<?php endif; ?>

<div style='margin:20px'>

    <div class='row'>
        <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Tiers</h1>
    </div>

    <div class='row'>
        <table class='table table-striped '>

            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Title</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tiers as $tier) : ?>
                <tr>
                    <td><?= $tier['id'] ?></td>
                    <td><?= htmlentities($tier['title']) ?></td>
                    <td><?= $tier['price'] ?></td>
                    <td>
                        <a class='btn btn-primary' href='tier-form.php?id=<?= $tier['id'] ?>' role='button'>Edit</a>
                        <a class='btn btn-danger' href='delete-tier.php?id=<?= $tier['id'] ?>' role='button'>Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class='row'>
        <div class='col'>
            <a class='btn btn-success' href='tier-form.php' role='button'>Add tier</a>
        </div>
    </div>
</div>

<?php require_once '_footer.php' ?>