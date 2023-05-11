# Storyverse

Storyverse is a web platform designed to facilitate reading, writing, and sharing of stories for kids. It provides users with two main features: the ability to write stories and the option to explore and read stories submitted by others.

## Features

- **Write Stories**: Storyverse offers two different methods for writing stories. Users can either freely enter their stories or use a simple storytelling framework to shape their narratives.

- **Read Stories**: Users can access a dedicated page, similar to a blog, where they can select stories, read them, and interact by leaving comments and liking the stories.

## Project Structure

The Storyverse project consists of the following files and folders:

- `index.php`: Main entry point for the web application.
- `about.php`: Page providing information about Storyverse.
- `contact.php`: Page allowing users to get in touch with the project team.
- `header.php`: Common header file containing the navigation menu displayed on all pages.
- `read_story.php`: HTML code for the Read Story page, where users can select and read stories, as well as interact through comments and likes.
- `write_story.php`: HTML file for the Write Story page, where users can contribute their own stories to be shared on the platform.
- `styles.css`: CSS file containing the styles used throughout the web application.
- `read_story_script.js`: JavaScript file handling the front-end functionality for the Read Story page.
- `write_story.js`: JavaScript file handling the front-end functionality for the Write Story page.
- `db_connection.php`: PHP code responsible for establishing the connection with the SQL database.
- `get_story.php`: PHP file used to fetch stories from the database and display them on the Read Story page.
- `send_contact.php`: PHP file for handling form submissions from the Contact page.
- `submit_comments.php`: PHP file for handling comments and likes on the Read Story page and recording them in the database.
- `submit_story.php`: PHP file for handling submissions from the Write Story page and recording form inputs in the database.
- `versions.json`: Version file used to help browsers update scripts and styles without clearing the cache every time.
- `languages.json`: JSON file containing a list of languages and codes used in the select language button on the Write Story page.
- `/images/`: Folder containing all the images used in the project.

## Getting Started

To run the Storyverse project locally, follow these steps:

1. Clone the repository: `git clone https://github.com/Leo-Jazz/storyverse.git`
2. Set up the required dependencies and configurations.
3. Launch the web application by opening `index.php` in your web browser.

## Contributing

Contributions to Storyverse are welcome! If you'd like to contribute, please follow the guidelines outlined in [CONTRIBUTING.md](link-to-contributing-file).

## License

Storyverse is released under the [MIT License](https://github.com/Leo-Jazz/storyverse/blob/main/LICENSE). Please refer to the LICENSE file for more details.

## Contact

If you have any questions, suggestions, or feedback, feel free to reach out to us at victorazzi@gmail.com.

---