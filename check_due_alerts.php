// check_due_alerts.php
<?php
require 'config.php';

$result = mysqli_query($conn, "SELECT * FROM alerts_schedules WHERE due_date <= CURDATE() AND status='Pending'");
while ($row = mysqli_fetch_assoc($result)) {
    // Notify user/admin
    // For example, insert into notifications table or send email
}
mysqli_close($conn);
?>