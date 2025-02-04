<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script> 
    // src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> 
       
      // Function to handle the "Register" button click
function registerClubs() {
    let selectedClubs = [];
    // Get all checkboxes
    let checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    
    // Collect the names of selected clubs
    checkboxes.forEach(function (checkbox) {
        selectedClubs.push(checkbox.value);
    });

    // Display selected clubs
    let registeredClubsContainer = document.getElementById('registeredClubs');
    registeredClubsContainer.innerHTML = ""; // Clear previous list

    selectedClubs.forEach(function (club) {
        let clubItem = document.createElement('div');
        clubItem.textContent = club;

        // Add an "Unregister" button for each club
        let unregisterButton = document.createElement('button');
        unregisterButton.textContent = "Unregister";
        unregisterButton.classList.add('btn', 'btn-danger', 'ms-2'); // Add Bootstrap styles
        unregisterButton.style.marginBottom = '10px'; // Add spacing directly

        unregisterButton.onclick = function () {
            unregisterClub(club); // Call unregister function
        };

        clubItem.appendChild(unregisterButton);
        registeredClubsContainer.appendChild(clubItem);
    });

    document.getElementById('registeredClubs').style.display = 'block';
}

// Function to unregister a club
function unregisterClub(clubName) {
    // Uncheck the corresponding checkbox
    let checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        if (checkbox.value === clubName) {
            checkbox.checked = false;
        }
    });

    // Remove the club from the displayed list
    let registeredClubsContainer = document.getElementById('registeredClubs');
    let clubItems = registeredClubsContainer.querySelectorAll('div');
    clubItems.forEach(function (clubItem) {
        if (clubItem.textContent.includes(clubName)) {
            registeredClubsContainer.removeChild(clubItem);
        }
    });
}

// Ensure JavaScript is loaded after the DOM
document.addEventListener('DOMContentLoaded', function () {
    // Your event listeners or initialization code can go here
});


    </script>
</head>

<body class ="bg-light">

   <h1> POPULAR RIGHT NOW </h1> <br>

    <a href ="adidas.php"> Adidas </a>
    <a href ="nike.php"> Nike </a>
    <a href ="puma.php"> Puma </a>

    <!-- Layout --> 
    <div class ="row mt-5">

   



</body>
</html>