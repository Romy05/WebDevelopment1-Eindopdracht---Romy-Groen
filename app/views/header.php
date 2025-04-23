<!DOCTYPE html>
<html lang="en">
<head>  
    <title>AutoMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
 <main>
   <div class="container">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
        
        <?php if (isset($_SESSION['user'])): ?>
              <?php if ($_SESSION['user']->type_of_user == \App\Models\Enums\UserType::Employee): ?>
                    <li class="nav-item"><a href="/appointment" class="nav-link">Appointments</a></li>
                    <li class="nav-item"><a href="/service" class="nav-link">Manage Services</a></li>
                    <li class="nav-item"><a href="/user" class="nav-link">Manage Users</a></li>
                    <li class="nav-item"><a href="/settings" class="nav-link">Settings</a></li>
                    <li class="nav-item"><a href="/logout" class="nav-link">Log Out</a></li>
              <?php endif; ?>
              <?php if ($_SESSION['user']->type_of_user == \App\Models\Enums\UserType::Customer): ?>
                    <li class="nav-item"><a href="/appointment/create/service" class="nav-link">Make an appointment</a></li>
                    <li class="nav-item"><a href="/settings" class="nav-link">Settings</a></li>
                    <li class="nav-item"><a href="/logout" class="nav-link">Log Out</a></li>    
              <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['user'])): ?>
        <li class="nav-item"><a href="/login" class="nav-link">Log In</a></li>
        <li class="nav-item"><a href="/register" class="nav-link">Register</a></li>
        <?php endif; ?>
      </ul>
    </header>
  </div>
<div class="container">