<?php
include __DIR__ . '/../../header.php';
use App\Services\ServiceService;
use App\Models\Service;
$services = (new ServiceService())->getAll();
?>

<div class="container d-flex justify-content-between align-items-start vh-100" style="margin-top: 5%;">
    <div class="card p-4" style="width: 60%; height: 50%;">
        <h2 class="mb-4 text-center">Select services before booking an appointment</h2>
        <div class="card-body">
            <form method="POST"id="appointment-service-form">
                <!-- Service Selection -->
                <div class="mb-3">
                    <label class="form-label">Select Services</label><br>
                    <?php foreach ($services as $service): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                            name="services[]" 
                            value="<?= htmlspecialchars($service->id) ?>" 
                            id="service-<?= htmlspecialchars($service->id) ?>" 
                            data-name="<?= htmlspecialchars($service->name) ?>" 
                            data-duration="<?= htmlspecialchars($service->duration_minutes) ?>" 
                            onclick="updateSelectedServices()">
                        <label class="form-check-label d-flex justify-content-between" 
                            for="service-<?= htmlspecialchars($service->id) ?>">
                            <span><?= htmlspecialchars($service->name) ?></span> 
                            <span class="duration"><?= $service->getMilitaryTime() ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <label for="license-plate" class="form-label">License Plate Number</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="license_plate" 
                        placeholder="AA-12-BB" 
                        name="license-plate"
                        required
                    >
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">See available dates</button>
                </div>
            </form>
        </div>
    </div>

     <!-- Panel to display selected services -->
     <div class="card p-4" style="width: 35%; height: 50%; display: flex; flex-direction: column;">
        <h3 class="text-center">Selected Services</h3>
        <ul id="selected-services-list"  class="list-group" style="flex-grow: 1; overflow-y: auto;">
            <!-- Selected services will be added here dynamically -->
        </ul>
        <!-- Total Duration Field (Always at the bottom) -->
        <div class="mt-3" id="total-duration-container">
            <strong>Total Duration:</strong> <span id="total-duration">00:00</span>
        </div>
    </div>
</div>

<script>
    // Convert minutes to military time (HH:mm)
    function convertToMilitaryTime(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
    }

    // Update the selected services list dynamically
    function updateSelectedServices() {
        const selectedServicesList = document.getElementById("selected-services-list");
        selectedServicesList.innerHTML = ''; // Clear the list before adding selected services

        let totalDurationInMinutes = 0; // Variable to store total duration

        const checkboxes = document.querySelectorAll("input[type='checkbox']:checked");
        checkboxes.forEach(function(checkbox) {
            const serviceName = checkbox.getAttribute("data-name");
            const serviceDuration = parseInt(checkbox.getAttribute("data-duration"));
            const formattedDuration = convertToMilitaryTime(serviceDuration); // Convert to military time format

            // Add to total duration
            totalDurationInMinutes += serviceDuration;

            // Create a list item and apply flexbox layout
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item", "d-flex", "justify-content-between"); // Add flexbox classes

            // Create spans for name and duration
            const nameSpan = document.createElement("span");
            nameSpan.textContent = serviceName;

            const durationSpan = document.createElement("span");
            durationSpan.classList.add("duration", "ml-auto"); // Align duration to the right
            durationSpan.textContent = formattedDuration;

            // Append the spans to the list item
            listItem.appendChild(nameSpan);
            listItem.appendChild(durationSpan);

            // Append the list item to the selected services list
            selectedServicesList.appendChild(listItem);
        });

        // Update the total duration display
        const totalDurationFormatted = convertToMilitaryTime(totalDurationInMinutes); // Convert total to military time format
        document.getElementById("total-duration").textContent = totalDurationFormatted; // Update the displayed total duration

        
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<?php
include __DIR__ . '/../../footer.php';
?>
