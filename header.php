<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    
    <!-- Page title -->
    <title>Storyverse</title>
</head>
<body>
    <!-- Header and navigation -->
    <header>
    <nav>
        <!-- Menu toggle checkbox -->
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        
        <!-- Navigation container -->
        <div class="nav-container">
            <a href="index.php">Home</a>
            <a href="write_story.php">Write Your Story</a>
            <a href="read_story.php">Read Stories</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            
            <!-- Hamburger menu icon -->
            <label for="menu-toggle" class="menu-icon"><i class="fas fa-bars"></i></label>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuIcon = document.getElementById('menu-icon');
        const navContainer = document.querySelector('.nav-container');

        menuIcon.addEventListener('click', function () {
            navContainer.classList.toggle('mobile-nav-active');
        });
    });
</script>


</body>
</html>
