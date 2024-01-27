<?php

require __DIR__ . '/dompdf/vendor/autoload.php';

include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit();
}

// Get the username of the currently logged-in user
$username = $_SESSION['username'];

if (isset($_POST['generate_pdf']) && isset($_POST['guest_id'])) {
    $guestId = $_POST['guest_id'];

    // Fetch guest data from the database associated with the username
    $query = "SELECT * FROM guest WHERE guest_id = '$guestId' AND username = '$username'";
    $result = mysqli_query($dbconn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $guest_name = $row['guest_name'];

        // Fetch header details from the 'header_details' table associated with the username
        $headerQuery = "SELECT * FROM header_details WHERE username = '$username'";
        $headerResult = mysqli_query($dbconn, $headerQuery);

        if ($headerResult && mysqli_num_rows($headerResult) > 0) {
            $headerRow = mysqli_fetch_assoc($headerResult);
            $groom = $headerRow['groom'];
            $bride = $headerRow['bride'];
            $wedding_date = $headerRow['wedding_date'];
            $wedding_location = $headerRow['wedding_location'];
        } else {
            // Default values in case header details are not found
            $groom = 'John Doe'; // Replace with the groom's name
            $bride = 'Jane Smith'; // Replace with the bride's name
            $wedding_date = 'Saturday, September 30, 2023'; // Replace with the wedding date
            $wedding_location = '123 Main Street, City, State'; // Replace with the wedding location
        }

        // Create a PDF document using DomPDF
        $pdf = new Dompdf\Dompdf();
        $pdf->loadHtml('
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Wedding Invitation</title>

            <style type="text/css">
            body {
                background-color: #f9f9f9;
                text-align: center;
                font-family: serif;
                border: 2px solid #e74c3c;
                padding: 80px;
            }

            .save-the-date {
                font-family: serif;
                font-size: 25px;
                color: #e74c3c;
            }

            .names {
                font-family: serif;
                font-size: 50px;
                margin: 20px 0;
            }

            .invitation {
                font-family: serif;
                font-size: 18px;
                margin-bottom: 10px;
            }

            .date {
                font-family: serif;
                font-size: 18px;
            }

            .location {
                font-family: serif;
                font-size: 18px;
            }

            </style>
            </head>
            <body>
            <div>
            <h1 class="save-the-date">Greetings, ' . $guest_name . '</h1>
            <h2 class="names">' . $groom . ' & ' . $bride . '</h2>
            <p class="invitation">We invite you to celebrate our wedding</p>
            <p class="date">' . $wedding_date . '</p>
            <p class="location">' . $wedding_location . '</p>
            </div>
            </body>
            </html>
            ');

        // (Optional) Set DomPDF options like paper size, orientation, etc.
        $pdf->setPaper('A5', 'landscape');

        // Render the HTML to PDF
        $pdf->render();

        // Output the generated PDF
        $pdf->stream();
    } else {
        // Guest not found
        echo "Guest not found.";
    }
} else {
    // Invalid request
    echo "Invalid request.";
}
?>