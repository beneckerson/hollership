<?php
/**
 * Contact Form Handler for The World's Greatest Scholarship In the Universe Scholarship
 * 
 * This script processes form submissions from the contact form and sends emails to multiple recipients.
 */

// Configuration
$config = [
    // List of recipient email addresses
    'recipients' => [
        // Add your recipient emails here
        'recipient1@example.com',
        'recipient2@example.com',
        // Add more as needed
    ],
    'subject_prefix' => '[Website Contact Form] ', // Prefix for email subject
    'from_email' => 'noreply@theworldsgreatestscholarshipintheuniversescholarship.com', // From email address
    'from_name' => 'Scholarship Website Contact Form', // From name
    'success_redirect' => 'thank-you.html', // Page to redirect to after successful submission
    'error_redirect' => 'error.html', // Page to redirect to after failed submission
];

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $subject = isset($_POST['subject']) ? filter_var($_POST['subject'], FILTER_SANITIZE_STRING) : '';
    $message = isset($_POST['message']) ? filter_var($_POST['message'], FILTER_SANITIZE_STRING) : '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If no errors, send email
    if (empty($errors)) {
        // Prepare email content
        $email_subject = $config['subject_prefix'] . $subject;
        
        $email_body = "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n\n";
        $email_body .= "Message:\n$message\n";
        
        // Set headers
        $headers = "From: {$config['from_name']} <{$config['from_email']}>\r\n";
        $headers .= "Reply-To: $name <$email>\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Send email to each recipient
        $success = true;
        foreach ($config['recipients'] as $recipient) {
            if (!mail($recipient, $email_subject, $email_body, $headers)) {
                $success = false;
                break;
            }
        }
        
        // Handle result
        if ($success) {
            // If AJAX request, return JSON response
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Your message has been sent! We will get back to you soon.']);
                exit;
            }
            
            // Otherwise redirect to success page
            header("Location: {$config['success_redirect']}");
            exit;
        } else {
            // If AJAX request, return JSON response
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
                exit;
            }
            
            // Otherwise redirect to error page
            header("Location: {$config['error_redirect']}");
            exit;
        }
    } else {
        // If AJAX request, return JSON response with errors
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Please correct the following errors:', 'errors' => $errors]);
            exit;
        }
        
        // Otherwise redirect to error page
        header("Location: {$config['error_redirect']}");
        exit;
    }
} else {
    // Not a POST request
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
    exit;
}
