<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capture and sanitize the form fields
    $company = strip_tags(trim($_POST["company"]));
    $contact_person = strip_tags(trim($_POST["contact_person"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check that data was actually sent
    if (empty($company) || empty($contact_person) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back with an error if fields are missing/invalid
        header("Location: contact.html?status=error");
        exit;
    }

    // Set the recipient email address
    $recipient = "reception1@kimohc.co.za";

    // Set the email subject
    $subject = "New Website Enquiry from: $company";

    // Build the email content
    $email_content = "Company Name: $company\n";
    $email_content .= "Contact Person: $contact_person\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    // Using a generic "website" sender prevents the server from flagging it as spam
    $email_headers = "From: website@kimohc.co.za\r\n";
    $email_headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Redirect to the contact page with a success flag in the URL
        header("Location: contact.html?status=success");
    } else {
        // Redirect to the contact page with an error flag in the URL
        header("Location: contact.html?status=error");
    }
} else {
    // If a user tries to load the PHP file directly, redirect them to the form
    header("Location: contact.html");
}
?>