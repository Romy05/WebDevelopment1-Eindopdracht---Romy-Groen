<?php
include __DIR__ . '/../../header.php';
require_once __DIR__ . '/../../../config/calendarconfig.php';

$appointment = $model;
$appointmentDuration = calculateDuration($appointment);
function calculateDuration($appointment) {
    $totalDuration = 0;
    foreach ($appointment->services as $service) {
        $totalDuration += $service->duration_minutes;
    }
    $hours = floor($totalDuration / 60);
    $minutes = $totalDuration % 60;
    return sprintf('%02d:%02d', $hours, $minutes);
}
?>
<div class="container d-flex flex-row align-items-start vh-100" style="margin-top: 5%; gap: 2rem;">
    <div class="card p-4" style="width:75%; height: auto;">
        <h2 class="mb-4 text-center">Make an Appointment</h2>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <button id="prev-week" class="btn btn-dark" disabled>← Previous</button>
                <button id="next-week" class="btn btn-dark">Next →</button>
            </div>
            <div id="weeks-container" class="d-flex flex-column gap-3" style="overflow-x: auto; white-space: nowrap; width: 100%;"></div>
        </div>
    </div>

    <div class="card p-4" style="width: 25%; height: auto; display: flex; flex-direction: column;">
        <h3 class="text-center">Selected Services</h3>
        <ul id="selected-services-list" class="list-group" style="flex-grow: 1; overflow-y: auto; max-height: 300px;">
            <?php foreach ($appointment->services as $service): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><?= htmlspecialchars($service->name) ?></span>
                    <span class="duration ml-auto"><?= htmlspecialchars($service->getMilitaryTime()) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="mt-3" id="total-duration-container">
            <strong>Total Duration:</strong> <span id="total-duration"><?= calculateDuration($appointment) ?></span>
        </div>
    </div>
</div>


<script>
let currentWeekIndex = 0;
const appointmentDurationString = <?= json_encode($appointmentDuration) ?>;
function timeStringToMinutes(timeString) {
    if (!timeString) {
        return 0; // Handle empty or null strings
    }
    const parts = timeString.split(':');
    if (parts.length === 2) {
        const hours = parseInt(parts[0]);
        const minutes = parseInt(parts[1]);
        if (!isNaN(hours) && !isNaN(minutes)) {
            return hours * 60 + minutes;
        }
    }
    return 0; // Return 0 if the string is invalid
}

const appointmentDuration = timeStringToMinutes(appointmentDurationString);
function getWeekDates(currentWeekIndex = 0) {
    const today = new Date();
    const dayOfWeek = today.getDay(); // 0 (Sunday) to 6 (Saturday)

    // Adjust to find the most recent Monday (or today if already Monday)
    let monday = new Date(today);
    monday.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1) + (currentWeekIndex * 7));

    // Generate dates from Monday to Friday
    const dates = [];
    for (let i = 0; i < 5; i++) {
        let currentDate = new Date(monday);
        currentDate.setDate(monday.getDate() + i);
        dates.push(currentDate);
    }
    return dates;
}



function isDateAvailable(date, existingAppointments, appointmentDuration) {
    let bookedMinutes = 0;
    const targetDate = date.toISOString().split('T')[0]; // Get YYYY-MM-DD   
    existingAppointments.forEach(appointment => {
        const appointmentDate = appointment.date.split(' ')[0]; //get YYYY-MM-DD
        if (appointmentDate === targetDate) {
            bookedMinutes += appointment.duration;
        }
    });

    const HOURS_PER_EMPLOYEE_PER_DAY = <?php echo HOURS_PER_EMPLOYEE_PER_DAY; ?>;
    const TOTAL_HOURS_PER_DAY = HOURS_PER_EMPLOYEE_PER_DAY * <?php echo count($totalEmployees) ?>;
    const remainingMinutes = TOTAL_HOURS_PER_DAY * 60 - bookedMinutes;
    return remainingMinutes >= appointmentDuration;
}
function generateWeekAvailability(existingAppointments, appointmentDuration) {
    const currentDate = new Date();
    const allWeeks = [];

    for (let week = 0; week < 1; week++) {
        const weekData = [];
        const weekDates = getWeekDates(currentWeekIndex);

        weekDates.forEach(date => {
            let isAvailable = isDateAvailable(date, existingAppointments, appointmentDuration) && date >= currentDate;
            weekData.push({
                day: date.toLocaleDateString('en-US', { weekday: 'short' }),
                fullDate: date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
                isAvailable: isAvailable
            });
        });
        
        allWeeks.push(weekData);
    }
    return allWeeks;
}

document.addEventListener("DOMContentLoaded", function() {
    


    const weeksContainer = document.getElementById("weeks-container");
    const prevButton = document.getElementById("prev-week");
    const nextButton = document.getElementById("next-week");

    let weekAppointments;
    async function fetchData(currentWeekIndex) {
    try {
        let response = await fetch('/appointment/create/availability?week=' + currentWeekIndex);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        weekAppointments = await response.json();

        
    } catch (error) {
        console.error('Error:', error);
    }
    renderWeeks(weekAppointments);
}
    fetchData(currentWeekIndex);

function renderWeeks(weekAppointments) { 

    let days = generateWeekAvailability(weekAppointments, appointmentDuration);




    weeksContainer.innerHTML = ""; // Clear previous content

    // Create a container for the week's days
    const weekDiv = document.createElement("div");
    weekDiv.classList.add("d-flex", "flex-row", "border", "rounded", "p-3", "bg-light", "justify-content-center", "gap-2");
    weekDiv.style.width = "100%";
    weekDiv.style.overflowX = "auto";

    // Loop through the extracted days and generate HTML
    days[0].forEach(day => {
        const dayCard = `
            <div class="p-2 text-center">
                <div class="card ${day.isAvailable ? 'bg-success text-white' : 'bg-light'}"
                    style="cursor: ${day.isAvailable ? 'pointer' : 'not-allowed'}; width: 140px; height: 140px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                        <strong>${day.day}</strong>
                        <p class="mb-0">${day.fullDate}</p>
                        ${day.isAvailable 
                            ? '<button class="btn btn-light btn-sm mt-2 book-button" data-date="' + day.fullDate + '">Book</button>' 
                            : '<small class="text-muted">Unavailable</small>'}
                    </div>
                </div>
            </div>`;

        weekDiv.innerHTML += dayCard;
    });

    weeksContainer.appendChild(weekDiv); // Append the generated week

    // Enable/disable navigation buttons
    prevButton.disabled = currentWeekIndex === 0;
}


    function bookAppointment(selectedDate) {
    const formData = new FormData();
    formData.append('date', selectedDate); // Add the selected date to the form data
    formData.append('services', <?= json_encode(array_column($appointment->services, 'id')) ?>); // Include selected services (adjust if necessary)

    fetch('/appointment/create', {
        method: 'POST',
        body: formData
    }).then(data => {
            window.location.href = '/appointment/create/success'; 
    })
}


    // Attach event listener to book buttons using event delegation
    weeksContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('book-button')) {
            const selectedDate = event.target.getAttribute('data-date');
            bookAppointment(selectedDate); // Call the booking function with selected date
        }
    });

    prevButton.addEventListener("click", function() {
        if (currentWeekIndex > 0) {
            currentWeekIndex -= 1;
            fetchData(currentWeekIndex);
        }
    });

    nextButton.addEventListener("click", function() {
            currentWeekIndex += 1;
            fetchData(currentWeekIndex);
 
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<?php include __DIR__ . '/../../footer.php'; ?>
