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
    <title>Contact - Storyverse</title>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <section class="contact-section">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! Whether you have questions, concerns, or just want to share your thoughts, don't hesitate to reach out. Fill out the contact form below, and our team will get back to you as soon as possible.</p>

            <form action="send_contact.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="5" required></textarea>

                <input type="submit" value="Submit" class="button">
            </form>
        </section>
        <section class="contact-form">
            <?php
            if (isset($_GET['success'])) {
                if ($_GET['success'] === 'true') {
                    echo "<div class='form-success'>Your message was sent successfully!</div>";
                } else {
                    echo "<div class='form-error'>There was an error sending your message. Please try again later.</div>";
                }
            }
            ?>
            <!-- Rest of the form -->
        </section>

    </main>

</body>
</html>
