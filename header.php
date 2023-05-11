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
            <!-- Hamburger menu icon -->
            <label for="menu-toggle" class="menu-icon"><span class="fas fa-bars"></span></label>

            <!-- Menu toggle checkbox -->
            <input type="checkbox" id="menu-toggle">

            <!-- Navigation container -->
            <div class="nav-container">
                <a href="index.php">Home</a>
                <a href="write_story.php">Write Your Story</a>
                <a href="read_story.php">Read Stories</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </div>
        </nav>
    </header>


    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const navContainer = document.querySelector('.nav-container');
            const menuIcon = document.querySelector('.menu-icon');

            menuToggle.addEventListener('change', function () {
                if (menuToggle.checked) {
                    navContainer.classList.add('mobile-nav-active');
                } else {
                    navContainer.classList.remove('mobile-nav-active');
                }
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 767) {
                    navContainer.classList.remove('mobile-nav-active');
                    menuToggle.checked = false;
                }
            });
        });
    </script>


</body>
</html>
