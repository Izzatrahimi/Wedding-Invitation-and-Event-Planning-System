<?php
include('../connection/dbconn.php');

$id = $_GET['id'];

$delete = "DELETE FROM user WHERE id='$id'";
$result = mysqli_query($dbconn, $delete) or die("Error: " . mysqli_error($dbconn));

if ($result) {
    $message = "User deleted successfully";
    ?>
    <script type="text/javascript">
        alert("<?php echo $message; ?>");
        window.location = "view_user.php";
    </script>
    <?php
} else {
    $message = "Failed to delete user";
    ?>
    <script type="text/javascript">
        alert("<?php echo $message; ?>");
        window.location = "view_user.php";
    </script>
    <?php
}
?>
