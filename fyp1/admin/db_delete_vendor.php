<?php
include('../connection/dbconn.php');

$id = $_GET['id'];

$delete = "DELETE FROM vendor WHERE vendor_id='$id'";
$result = mysqli_query($dbconn, $delete) or die("Error: " . mysqli_error($dbconn));

if ($result) {
    $message = "Vendor deleted successfully";
    ?>
    <script type="text/javascript">
        alert("<?php echo $message; ?>");
        window.location = "view_vendor.php";
    </script>
    <?php
} else {
    $message = "Failed to delete vendor";
    ?>
    <script type="text/javascript">
        alert("<?php echo $message; ?>");
        window.location = "view_vendor.php";
    </script>
    <?php
}
?>
