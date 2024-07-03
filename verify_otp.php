<?php
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'otp' key exists in $_POST array
    if (isset($_POST['otp'])) {
        $submittedOtp = $_POST['otp'];
        
        // Retrieve the stored OTP from the session
        $storedOtp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;

        // Verify the OTP
        if ($storedOtp && $submittedOtp == $storedOtp) {
            echo "OTP verified successfully!";
            // Optionally, unset the OTP after successful verification
            unset($_SESSION['otp']);
        } else {
            echo "Invalid OTP. Please try again.";
        }
    } else {
        echo "No OTP provided.";
    }
} else {
    // If the form wasn't submitted, redirect to the form page
    header("Location: ./index.html");
    exit();
}

?>
