<?php

// =====================================================
// DATABASE CONNECTION
// =====================================================

$servername = "localhost";
$username   = "root";
$password   = "";   // Keep your actual MySQL password here
$dbname     = "regform";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    showMessage(
        "Connection Failed",
        "Oops! We couldn't connect to the registration system. Please try again.",
        "error"
    );
}

$conn->set_charset("utf8mb4");


// =====================================================
// CHECK REQUEST METHOD
// =====================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    showMessage(
        "Invalid Request",
        "Please submit the registration form to continue.",
        "error"
    );
}


// =====================================================
// GET FORM DATA SAFELY
// =====================================================

$fname          = trim($_POST['fname'] ?? '');
$mname          = trim($_POST['mname'] ?? '');
$lname          = trim($_POST['lname'] ?? '');
$email          = trim($_POST['email'] ?? '');
$dob            = trim($_POST['dob'] ?? '');
$gender         = trim($_POST['gender'] ?? '');
$occupation     = trim($_POST['occupation'] ?? '');
$areaofinterest = trim($_POST['areaofinterest'] ?? '');
$mobile         = trim($_POST['mobile'] ?? '');
$address        = trim($_POST['address'] ?? '');
$country        = trim($_POST['country'] ?? '');


// =====================================================
// VALIDATION
// =====================================================

if (
    empty($fname) ||
    empty($lname) ||
    empty($email) ||
    empty($dob) ||
    empty($gender) ||
    empty($occupation) ||
    empty($areaofinterest) ||
    empty($mobile) ||
    empty($address) ||
    empty($country)
) {

    showMessage(
        "Incomplete Form",
        "Please fill in all the required fields and try again.",
        "warning"
    );
}


// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    showMessage(
        "Invalid Email",
        "Please enter a valid email address.",
        "warning"
    );
}


// Validate mobile
if (!preg_match('/^[0-9]{10}$/', $mobile)) {

    showMessage(
        "Invalid Mobile Number",
        "Please enter a valid 10-digit mobile number.",
        "warning"
    );
}


// =====================================================
// INSERT DATA USING PREPARED STATEMENT
// =====================================================

$sql = "INSERT INTO form
(
    fname,
    mname,
    lname,
    email,
    dob,
    gender,
    occupation,
    areaofinterest,
    mobile,
    address,
    country
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);


// Check query preparation
if (!$stmt) {

    $conn->close();

    showMessage(
        "Something Went Wrong",
        "We couldn't process your registration right now. Please try again.",
        "error"
    );
}


// Bind values
$stmt->bind_param(
    "sssssssssss",
    $fname,
    $mname,
    $lname,
    $email,
    $dob,
    $gender,
    $occupation,
    $areaofinterest,
    $mobile,
    $address,
    $country
);


// =====================================================
// EXECUTE
// =====================================================

if ($stmt->execute()) {

    $stmt->close();
    $conn->close();

    showMessage(
        "Registration Successful!",
        "Welcome, " . htmlspecialchars($fname) .
        "! Your registration has been successfully completed.",
        "success"
    );

} else {

    $stmt->close();
    $conn->close();

    showMessage(
        "Registration Failed",
        "We couldn't save your registration. Please check your details and try again.",
        "error"
    );
}


// =====================================================
// BEAUTIFUL INTERACTIVE MESSAGE
// =====================================================

function showMessage($title, $message, $type)
{

    if ($type === "success") {

        $icon = "✓";
        $class = "success";

    } elseif ($type === "warning") {

        $icon = "!";
        $class = "warning";

    } else {

        $icon = "×";
        $class = "error";
    }

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($title); ?></title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;

            font-family:
                "Segoe UI",
                Arial,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #667eea,
                    #764ba2
                );

            overflow: hidden;
        }


        /* Background decoration */

        body::before,
        body::after {

            content: "";

            position: fixed;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.10);

            animation: float 6s infinite ease-in-out;
        }

        body::before {

            top: -80px;
            left: -80px;
        }

        body::after {

            bottom: -100px;
            right: -70px;

            animation-delay: 2s;
        }


        @keyframes float {

            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }
        }


        /* Main Card */

        .card {

            position: relative;

            width: 100%;
            max-width: 520px;

            padding: 45px 35px;

            text-align: center;

            background:
                rgba(255,255,255,0.96);

            border-radius: 28px;

            box-shadow:
                0 25px 70px
                rgba(0,0,0,0.25);

            animation:
                cardAppear 0.7s ease;
        }


        @keyframes cardAppear {

            from {

                opacity: 0;

                transform:
                    translateY(40px)
                    scale(0.90);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        /* Icon */

        .icon {

            width: 95px;
            height: 95px;

            margin:
                0 auto 25px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 52px;

            font-weight: bold;

            color: white;

            animation:
                iconPop 0.6s
                0.2s both;
        }


        .success .icon {

            background:
                linear-gradient(
                    135deg,
                    #20c997,
                    #0ca678
                );

            box-shadow:
                0 10px 30px
                rgba(32,201,151,0.35);
        }


        .warning .icon {

            background:
                linear-gradient(
                    135deg,
                    #ffc107,
                    #f59f00
                );
        }


        .error .icon {

            background:
                linear-gradient(
                    135deg,
                    #ff6b6b,
                    #e03131
                );
        }


        @keyframes iconPop {

            0% {

                opacity: 0;

                transform:
                    scale(0.3)
                    rotate(-20deg);
            }

            70% {

                transform:
                    scale(1.15)
                    rotate(5deg);
            }

            100% {

                opacity: 1;

                transform:
                    scale(1)
                    rotate(0);
            }
        }


        /* Heading */

        h1 {

            font-size: 30px;

            color: #222;

            margin-bottom: 14px;
        }


        /* Message */

        .message {

            color: #666;

            font-size: 16px;

            line-height: 1.7;

            margin-bottom: 30px;
        }


        /* Success extra text */

        .success-note {

            display: inline-block;

            padding: 10px 18px;

            margin-bottom: 25px;

            border-radius: 50px;

            background: #e9fdf5;

            color: #087f5b;

            font-size: 14px;

            font-weight: 600;
        }


        /* Buttons */

        .buttons {

            display: flex;

            justify-content: center;

            gap: 12px;

            flex-wrap: wrap;
        }


        .btn {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 150px;

            padding: 14px 22px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 15px;

            font-weight: 600;

            transition:
                transform 0.25s,
                box-shadow 0.25s;
        }


        .btn:hover {

            transform:
                translateY(-3px);

        }


        .primary {

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #667eea,
                    #764ba2
                );

            box-shadow:
                0 8px 20px
                rgba(102,126,234,0.3);
        }


        .secondary {

            color: #555;

            background: #f1f3f5;
        }


        /* Footer */

        .footer {

            margin-top: 28px;

            font-size: 13px;

            color: #999;
        }


        /* Mobile */

        @media (max-width: 500px) {

            .card {

                padding: 35px 22px;
            }

            h1 {

                font-size: 25px;
            }

            .buttons {

                flex-direction: column;
            }

            .btn {

                width: 100%;
            }
        }

    </style>

</head>


<body>


<div class="card <?php echo $class; ?>">


    <div class="icon">

        <?php echo $icon; ?>

    </div>


    <h1>

        <?php echo htmlspecialchars($title); ?>

    </h1>


    <p class="message">

        <?php echo htmlspecialchars($message); ?>

    </p>


    <?php if ($type === "success") { ?>

        <div class="success-note">

            ✨ You're all set! Thank you for registering.

        </div>

    <?php } ?>


    <div class="buttons">


        <?php if ($type === "success") { ?>

            <a
                href="index.html"
                class="btn primary">

                📝 Register Again

            </a>

            <a
                href="index.html"
                class="btn secondary">

                🏠 Go Home

            </a>


        <?php } else { ?>

            <a
                href="javascript:history.back()"
                class="btn primary">

                ↩ Try Again

            </a>

            <a
                href="index.html"
                class="btn secondary">

                🏠 Go Back

            </a>

        <?php } ?>


    </div>


    <div class="footer">

        Your information has been processed securely.

    </div>


</div>


</body>

</html>

<?php

    exit;
}

?>
