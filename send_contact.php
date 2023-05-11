<?php

// Replace these with your own email and subject
$to = 'victorazzi@gmail.com';
$subject = 'Storyverse Contact Form Submission';

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Create the email body
$email_body = "Name: {$name}\n";
$email_body .= "Email: {$email}\n\n";
$email_body .= "Message:\n{$message}";

// Set email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "From: {$email}\r\n";
$headers .= "Reply-To: {$email}\r\n";

// Send the email
if (mail($to, $subject, $email_body, $headers)) {
    header("Location: contact.php?success=true");
} else {
    header("Location: contact.php?success=false");
}
