<?php

require_once 'functions.php';

// Create a try/catch block to handle database exceptions
try {
    // Connect to the database using the connect function
    $db = connect();

    // Create the $membersQuery
    $membersQuery = $db->query('SELECT members.*, tiers.title FROM members INNER JOIN tiers ON members.tier_id = tiers.id');
    // Fetch all members and assign the result to $members
    $members = $membersQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo $e->getMessage();
}

// Close the database connection here
$membersQuery = null;
$db = null;
?>

<?php require_once '_header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Home</a>
<a href='tiers.php' class='btn btn-secondary m-2 active' role='button'>Tiers</a>

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
        <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Members</h1>
    </div>
    <div class='row'>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>First Name</th>
                    <th scope='col'>Last Name</th>
                    <th scope='col'>Address</th>
                    <th scope='col'>Tier</th>
                    <th scope='col'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member) : ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td><?= htmlentities($member['first_name']) ?></td>
                    <td><?= htmlentities($member['last_name']) ?></td>
                    <td><?= htmlentities($member['address']) ?></td>
                    <td><?= htmlentities($member['title']) ?></td>
                    <td>
                        <a class='btn btn-primary' href='member-form.php?id=<?= $member['id'] ?>' role='button'>Edit</a>
                        <a class='btn btn-danger' href='delete-member.php?id=<?= $member['id'] ?>'
                            role='button'>Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class='row'>
        <div class='col'>
            <a class='btn btn-success' href='member-form.php' role='button'>Add member</a>
        </div>
    </div>
</div>

<?php require_once '_footer.php' ?>