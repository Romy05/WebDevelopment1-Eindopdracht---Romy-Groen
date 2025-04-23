<?php
include __DIR__ . '/../header.php';
?>

<h1>AutoMate</h1>

<?php if (!isset($_SESSION['user'])): ?>
<div style="display: flex; justify-content: center; align-items: center; height: 70vh; flex-direction: column;">
    <div style="display: flex; gap: 20px;">
        <a href="/login" style="text-decoration: none;">
            <button style="padding: 15px 30px; font-size: 20px; border: none; background-color: blue; color: white; border-radius: 5px; cursor: pointer;">
                Login
            </button>
        </a>
        <a href="/register" style="text-decoration: none;">
            <button style="padding: 15px 30px; font-size: 20px; border: none; background-color: green; color: white; border-radius: 5px; cursor: pointer;">
                Register
            </button>
        </a>
    </div>
</div>
<?php else:?>
<div style="display: flex; justify-content: center; align-items: center; height: 70vh; flex-direction: column;">
    <h2>Welcome, <?= $_SESSION['user']->first_name ?>!</h2>
    <?php if ($_SESSION['user']->type_of_user == \App\Models\Enums\UserType::Customer): ?>
    <a href="/appointment/create/service" style="text-decoration: none;">
        <button style="padding: 15px 30px; font-size: 20px; border: none; background-color: blue; color: white; border-radius: 5px; cursor: pointer;">
            Make an appointment
        </button>
    </a>
    <?php endif; ?>
<?php endif?>

<?php 
include __DIR__ . '/../footer.php';
?>
