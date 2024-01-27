<?php
// Include the database connection file
include('../connection/dbconn.php');
include('../registration/session.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit;
}

// Retrieve the wedding budget submitted by the user
$weddingBudget = $_POST['wedding_budget'];

// Retrieve the vendor categories from the database
$query = "SELECT DISTINCT vendor_category FROM vendor";
$result = mysqli_query($dbconn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $categories = [];
}

// Select one vendor from each vendor category within the budget
$selectedVendors = [];

foreach ($categories as $category) {
    $vendorCategory = $category['vendor_category'];

    // Query the database to select a vendor within the budget for each category
    $username = $_SESSION['username'];
    $query = "SELECT * FROM vendor WHERE vendor_category = '$vendorCategory' AND vendor_price <= $weddingBudget AND username = '$username' ORDER BY vendor_price ASC LIMIT 1";
    $result = mysqli_query($dbconn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $vendor = mysqli_fetch_assoc($result);
        $selectedVendors[] = $vendor;
    }
}

// Calculate the total price of the selected vendors
$totalPrice = 0;
foreach ($selectedVendors as $vendor) {
    $totalPrice += $vendor['vendor_price'];
}

if ($totalPrice > $weddingBudget) {
    // Display error message and redirect back to the form
    echo "Not enough budget, please re-enter the budget amount";
    header("Location: personalized_vendors.php?vendors=");
    exit();

} elseif (empty($selectedVendors)) {
    header("Location: personalized_vendors.php?vendors=");
    exit();
    
} else {
    // Redirect back to personalized_vendor.php with selected vendors' data
    header("Location: personalized_vendors.php?vendors=" . urlencode(serialize($selectedVendors)));
    exit();
}

// Close the database connection
mysqli_close($dbconn);
?>
