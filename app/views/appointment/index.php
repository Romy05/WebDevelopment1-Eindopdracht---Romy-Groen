<?php
include __DIR__ . '/../header.php';
$weekOffset = isset($_GET['week']) ? (int)$_GET['week'] : 0;
$startDate = strtotime("monday this week +$weekOffset week");
$allAppointments = $model;
?>
<style>
    .calendar {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        overflow-x: auto;
    }
    .day {
        flex: 1;
        min-width: 150px;
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .day strong {
        display: block;
        font-size: 1.2em;
        margin-bottom: 5px;
    }
    table {
        width: 100%;
        font-size: 0.9em;
    }
    td[contenteditable="true"] {
        background-color: #fff3cd;
    }
</style>
<div class="container">
    <h2 class="text-center my-4">Weekly Calendar with Appointments</h2>
    <div class="calendar">
    <?php
        for ($i = 0; $i < 5; $i++) { // Only show Monday to Friday
            $currentDate = strtotime("+$i day", $startDate);
            echo '<div class="day">';
            echo '<strong>' . date('l', $currentDate) . '</strong>';
            echo '<div>' . date('F j, Y', $currentDate) . '</div>';
            echo '<table class="table table-sm table-bordered mt-2">';
            echo '<thead class="table-light"><tr><th>License Plate</th><th>Services</th><th>Total Duration</th></tr></thead>';
            echo '<tbody>';
            foreach ($allAppointments as $appointment) {
                if (date('Y-m-d', strtotime($appointment->getDate())) === date('Y-m-d', $currentDate)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($appointment->getLicensePlate()) . '</td>'; // Show license plate
                    echo '<td>';
            
                    // Loop through services
                    $totalDuration = 0;
                    foreach ($appointment->services as $service) {
                        echo htmlspecialchars($service->getName()) .'<br>';
                        $totalDuration += $service->getDurationInMinutes();
                    }
            
                    $hours = floor($totalDuration / 60);
                        $minutes = $totalDuration % 60;
                        $formattedDuration = ($hours > 0 ? "$hours:" : "0:") . ($minutes > 0 ? "$minutes" : "00");
                
                        echo '</td>';
                        echo '<td>' . htmlspecialchars($formattedDuration) . '</td>'; // Show total duration in hours and minutes
                        echo '</tr>';
                }
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="text-center mt-4">
        <a class="btn btn-secondary me-2" href="/appointment?week=<?php echo $weekOffset - 1; ?>">Previous Week</a>
        <a class="btn btn-success me-2" href="/appointment?week=0">Current Week</a>
        <a class="btn btn-primary" href="/appointment?week=<?php echo $weekOffset + 1; ?>">Next Week</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<?php
include __DIR__ . '/../footer.php';
?>
