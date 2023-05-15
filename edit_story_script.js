document.addEventListener("DOMContentLoaded", () => {
    initEditStory();
});

function initEditStory() {
    const form = document.getElementById("edit-story-form");
    const storyQuill = new Quill("#story_text", {
        theme: "snow",
    });

    const translationQuill = new Quill("#translation_text", {
        theme: "snow",
    });

    const fetchStoryDataButton = document.getElementById("fetch-story-data");
    const storyIdInput = document.getElementById("story-id-input");

    fetchStoryDataButton.addEventListener("click", async () => {
        const storyId = storyIdInput.value;
        if (!storyId) {
            alert("Please enter a valid story ID");
            return;
        }

        const response = await fetch(`get_story.php?id=${storyId}`);
        const storyData = await response.json();

        if (!storyData.success) {
            alert("Failed to fetch story data");
            return;
        }

        // Populate the form fields with fetched data
        document.getElementById("id").value = storyId;
        document.getElementById("story_name").value = storyData.story_name;
        document.getElementById("author_name").value = storyData.author_name;
        storyQuill.setContents(storyQuill.clipboard.convert(storyData.story_text));
        translationQuill.setContents(translationQuill.clipboard.convert(storyData.translation_text));
        
        // Set the selected language in the dropdowns
        document.getElementById("story_language").value = storyData.story_language;
        document.getElementById("translation_language").value = storyData.translation_language;
     
    });

    fetch("languages.json")
    .then(response => response.json())
    .then(languages => {
        const storyLanguageSelect = document.getElementById("story_language");
        const translationLanguageSelect = document.getElementById("translation_language");

        languages.forEach(language => {
            storyLanguageSelect.options.add(new Option(language.name, language.code));
            translationLanguageSelect.options.add(new Option(language.name, language.code));
        });
    })
    .catch(error => console.error("Error:", error));

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        // Extract the contents of the Quill editors
        const story_text = storyQuill.root.innerHTML;
        const translation_text = translationQuill.root.innerHTML;

        // Create a FormData object and append the extracted content
        const formData = new FormData(form);
        formData.append("story_text", story_text);
        formData.append("translation_text", translation_text);

        const response = await fetch("update_story.php", {
            method: "POST",
            body: formData,
        });

        const data = await response.json();

        if (data.success) {
            alert("Story updated successfully!");
            window.location.href = `read_story.php?id=${formData.get("id")}`;
        } else {
            alert("Failed to update the story. Please try again.");
        }
    });



}
