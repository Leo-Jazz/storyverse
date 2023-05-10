# storyverse
Web platform for reading, writing and sharing stories for kids

The platfomr is called Storyverse and has the objective to help people write, share and read stories for kids. It has basically two main parts, one feature to write your stories and one for reading the stories submitted.

To write stories, we have two different input methods, a freely entry method and a simple storytelling framework method to help shape the story.

/
index.php
about.php
contact.php
header.php (contain the navigation menu the is displayed in all pages)
read_story.php (HTML code for the Red Story page - it allows users to select the story, read it and intereact trough commenting and liking. Very similar to a blog page)
write_story.php (HTML file for the Write Sotry page - where users can add their own stories to be shared in the platform)
styles.css (CSS styles)
read_story_script_js (Java Script handling front end for Red Story Page)
write_story_js (Java Script handling front end for Write Story Page)
db_connection.php (PHP code with SQL data base connection)
get_story.php (PHP file to fetch stories from data base to be displayed on Read Story)
send_contact.php (PHP file to handle form submission fro Contact page)
submit_comments.php (PHP file to handle comments and likes at Read Story, to be able to record them in or data base)
submit_story.php (PHP file to handle Write Story page, recording form inputs on our data base)
versions.json (Version files to help browsers to update scripts and styles without clearing cash all times)
langauges.json (List of languages and codes used on our select language button in Write Story)
/images/ (folder with all images used in the project)
