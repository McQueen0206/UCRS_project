<?php
include("database2.php");

$student_id = $_GET['student_id'] ?? '';
$otp = $_POST['otp'] ?? '';
$error = "";
$success = false;
$expires_at = "";

// Fetch OTP details and expiration time
if ($student_id) {
    $stmt = $con->prepare("SELECT * FROM otp_verification WHERE student_id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $otp_data = $stmt->fetch();
        $expires_at = $otp_data['expires_at']; // Fetch expiration time for the timer
    }
}

// Handle OTP submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $con->prepare("SELECT * FROM otp_verification WHERE student_id = :student_id AND otp = :otp");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':otp', $otp);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $otp_data = $stmt->fetch();
        $current_time = date("Y-m-d H:i:s");

        if ($current_time > $otp_data['expires_at']) {
            $error = "Your OTP has expired. Please request a new one.";
        } else {
            // OTP is valid
            $con->prepare("DELETE FROM otp_verification WHERE student_id = :student_id")->execute([':student_id' => $student_id]);
            header("Location: login.php?success=1"); // Redirect with a success parameter
            exit;
        }
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}

$success = isset($_GET['success']) ? $_GET['success'] : false;
?>
<!DOCTYPE html>
<html>
<title>OTP Verification</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    Registration successful! Please verify your OTP below.
                </div>
            <?php endif; ?>
            <h3 class="card-title">Verify OTP</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="alert alert-info" id="timer-alert">
                OTP will expire in: <span id="timer"></span>
            </div>
            <form method="post">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input class="form-control" type="text" name="otp" id="otp" placeholder="Enter OTP" required>
                </div>
                <button class="btn btn-primary btn-block" type="submit" id="submit-btn">Verify OTP</button>
            </form>
            <form method="post" action="resend_otp.php?student_id=<?php echo $student_id; ?>">
                <button class="btn btn-secondary btn-block mt-2" type="submit">Resend OTP</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Calculate the remaining time and display the countdown timer
    const expiresAt = "<?php echo $expires_at; ?>";
    const timerElement = document.getElementById('timer');
    const submitButton = document.getElementById('submit-btn');

    if (expiresAt) {
        const expirationTime = new Date(expiresAt).getTime();
        const interval = setInterval(() => {
            const currentTime = new Date().getTime();
            const timeLeft = expirationTime - currentTime;

            if (timeLeft <= 0) {
                clearInterval(interval);
                document.getElementById('timer-alert').innerHTML = "Your OTP has expired. Please request a new one.";
                submitButton.disabled = true; // Disable the submit button
                submitButton.classList.add('btn-secondary'); // Change button style to indicate it's disabled
                submitButton.classList.remove('btn-primary');
            } else {
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                timerElement.textContent = `${minutes}m ${seconds}s`;
            }
        }, 1000);
    }
</script>
</body>
</html>
