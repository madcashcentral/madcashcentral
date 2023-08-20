<?php
// Function to establish database connection
function connectToDatabase()
{
    global $PDOCONN, $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
    // Database configuration
    // defined('BASEPATH') OR exit('No direct script access allowed'); //prevent direct script access
    $DB_HOST = 'localhost'; // database host name or ip address
    $DB_USER = 'root'; // database username
    $DB_PASS = ''; // database password
    $DB_NAME = 'sublinks'; // database name
    $DB_ENCODING = 'utf8mb4'; // db character encoding. set to match your database table's character set. note: utf8 is an alias of utf8mb3/utf8mb4
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // set the error mode to exceptions (this is the default setting now in php8+)
			PDO::ATTR_EMULATE_PREPARES => false, // run real prepared queries
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // set default fetch mode to assoc
			];
    $PDOCONN = new pdo("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_ENCODING",$DB_USER,$DB_PASS,$options);
    if ($PDOCONN->connect_error) {
        die("Connection failed: " . $PDOCONN->connect_error);
    }
    return $PDOCONN;
}

function getContent($type)
{
    $host = "localhost";
    $database = "sublinks";

    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn = "SELECT content FROM html WHERE type = ?";
        $stmt = $pdo->prepare($conn);
        $stmt->execute([$type]);

        $content = $stmt->fetchColumn();

        $stmt->closeCursor();

        return $content;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
// Function to sanitize user input
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to generate a random activation token
function generateActivationToken()
{
    $length = 32;
    $token = bin2hex(random_bytes($length));
    return $token;
}

// Function to generate CSRF token
function generateCsrfToken()
{
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Function to validate CSRF token
function validateCsrfToken($token)
{
    if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token) {
        unset($_SESSION['csrf_token']);
        return true;
    }
    return false;
}


// Function to send account activation email
function sendActivationEmail($email, $activationToken)
{
    $subject = "Account Activation";
    $message = "Please click the following link to activate your account:\n\n";
    $message .= "Activation Link: http://example.com/activate.php?token=" . urlencode($activationToken);

    // You can use a library like PHPMailer or the built-in mail() function to send the email
    // Here's an example using PHPMailer:
    // require_once 'path/to/PHPMailerAutoload.php';
    // $mail = new PHPMailer();
    // $mail->isSMTP();
    // $mail->Host = 'smtp.example.com';
    // $mail->Port = 587;
    // $mail->SMTPAuth = true;
    // $mail->Username = 'your_email@example.com';
    // $mail->Password = 'your_email_password';
    // $mail->setFrom('your_email@example.com', 'Your Name');
    // $mail->addAddress($email);
    // $mail->Subject = $subject;
    // $mail->Body = $message;
    // if (!$mail->send()) {
    //     handleError($mail->ErrorInfo);
    // }
}


// Function to validate password strength
function validatePasswordStrength($password)
{
    // Implement your password strength rules here
    // Example: Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    return preg_match($pattern, $password);
}

// Function to validate reCAPTCHA response
function validateRecaptcha($recaptchaResponse)
{
    global $secretKey;
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
	$secretKey = "6LcRgRIaAAAAABeU589G39732MmwcAhI0ftebUWq";
    $recaptchaData = array(
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    );
    $recaptchaOptions = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($recaptchaData)
        )
    );
    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResult = json_decode($recaptchaResult, true);
    return $recaptchaResult['success'] && $recaptchaResult['score'] >= 0.5;
}


// Function to securely hash passwords
function hashPassword($password) {
    $options = [
        'cost' => 12, // Increase the cost for better security (higher value means slower hashing)
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}


// Function to handle errors
function handleError($errorMessage)
{
    // You can handle the error based on your requirements
    // For example, display an error message to the user or log the error
    echo "Error: " . $errorMessage;
    exit();
}
?>