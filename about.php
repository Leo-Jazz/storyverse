<?php
$versions = json_decode(file_get_contents('versions.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3MY8P0HHH2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3MY8P0HHH2');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css?v=<?= $versions['styles'] ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <title>About - Storyverse of Stories</title>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <section class="about-section">
            <h2>About Storyverse</h2>
            <p>Storyverse is a platform that allows families to share and create stories for their children. Our mission is to create a universe, on top of ours, where stories and imagination can freely gaing life.</p>
            <p>It was born out of a passion for storytelling and the desire to create a space where everyone can share their own stories. Our community consists of parents, teachers, and creative minds who understand the power of stories and their impact on children's lives.</p>
            <p>We believe that everyone has a unique story to tell, and through Storyverse, we aim to provide a platform that nurtures creativity and fosters a love for reading and writing. Join us on this journey as we create a world of stories together.</p>

            <h3>Our Story</h3>
            <p>This idea started with the wish to publish some stories I invented for my daughters, when I joined Buildspace Nights & Weeks Season 3, I decided to give this wish a place to create form!</p>

            <h3>Our Team</h3>
            <p>The team behind Storyverse is basically me, Leo Figueiredo, ChatGPT and my newborn daughter, Antonela, who is constatly sleeping on my lap while I try to create this platform!</p>
            <img src="images/team_photo.jpg" alt="Our Team" class="team-photo">

            <h3>Contact Us</h3>
            <p>If you have any questions, suggestions, or just want to say hi, feel free to contact us at victorazzi@gmail.com (We are still on beta! We do not have an oficcial e-mail yet!). We'd love to hear from you!</p>
        </section>
    </main>

</body>
</html>
