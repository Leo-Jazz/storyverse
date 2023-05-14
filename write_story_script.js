document.addEventListener("DOMContentLoaded", function () {
  const inputMethodFreely = document.getElementById("input_method_freely");
  const inputMethodStorytelling = document.getElementById("input_method_storytelling");
  const freelyContainer = document.getElementById("freely-container");
  const frameContainer = document.getElementById("frame-container");
  const form = document.getElementById("write-story-form");
  const submitFreely = document.getElementById("submit-freely");
  const submitFrame = document.getElementById("submit-frame");

  const quill_options = {
    theme: 'snow',
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
        ['blockquote', 'code-block'],
  
        [{ 'header': 1 }, { 'header': 2 }], // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }], // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }], // outdent/indent
        [{ 'direction': 'rtl' }], // text direction
  
        [{ 'size': ['small', false, 'large', 'huge'] }], // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  
        [{ 'color': [] }, { 'background': [] }], // dropdown with defaults
        [{ 'font': [] }],
        [{ 'align': [] }],
  
        ['clean'], // remove formatting button
        ['link', 'image', 'video'] // link and image, video
      ],
    },
    
  };

  var freelyEditor = new Quill('#story_text', quill_options);
  var block1Editor = new Quill('#block1', quill_options);
  var block2Editor = new Quill('#block2', quill_options);
  var block3Editor = new Quill('#block3', quill_options);
  var translationEditorFreely = new Quill('#translation_text_freely', quill_options);
  var translationEditorFrame = new Quill('#translation_text_frame', quill_options);

  // Set the pre-filled text for Block 1, Block 2, and Block 3
  block1Editor.setContents([
    { insert: 'Once upon a time...\n\n' },
    { insert: 'And everyday...\n\n' },
    { insert: 'But one day...\n' },
  ]);
  
  block2Editor.setContents([
    { insert: 'And because of that...\n\n' },
    { insert: 'And because of that...\n\n' },
    { insert: '... (how many events are needed)\n' },
  ]);
  
  block3Editor.setContents([
    { insert: 'Until finally...\n\n' },
    { insert: 'And since then...\n' },
  ]);
   
  // Function to update the visibility of the input method fields based on the selected input method
  function updateInputMethodVisibility() {
    // Get the value of the selected input method
    const freelyVisible = inputMethodFreely.checked;

    // Hide or show the freely input method container based on the selected input method
    freelyContainer.style.display = freelyVisible ? "block" : "none";
    freelyContainer.style.visibility = freelyVisible ? "visible" : "hidden";

    // Hide or show the frame input method container based on the selected input method
    frameContainer.style.display = inputMethodStorytelling.checked ? "block" : "none";
    frameContainer.style.visibility = inputMethodStorytelling.checked ? "visible" : "hidden";

    // Update input_method field value based on the selected input method
    const inputMethodField = form.querySelector("input[name='input_method']");
    inputMethodField.value = freelyVisible ? "freely" : "frame";

    // Disable or enable form elements based on the selected input method
    Array.from(freelyContainer.querySelectorAll("input, textarea")).forEach((element) => {
      element.disabled = !freelyVisible;
    });

    Array.from(frameContainer.querySelectorAll("input, textarea")).forEach((element) => {
      element.disabled = freelyVisible;
    });
  }

  // This code updates the visibility of the input methods
  // depending on the value of the inputMethod select element.
  inputMethodFreely.addEventListener("change", updateInputMethodVisibility);
  inputMethodStorytelling.addEventListener("change", updateInputMethodVisibility);

  updateInputMethodVisibility();

  // Converts a given `FormData` object to a plain JavaScript object.
  function formDataToObject(formData) {
    const data = {};
    for (const [key, value] of formData.entries()) {
      data[key] = value;
    }
    return data;
  }
  
  function loadLanguages() {
    fetch('languages.json')
      .then((response) => response.json())
      .then((languages) => {
        const storyLanguageFreelySelect = document.getElementById('story_language_freely');
        const storyLanguageFrameSelect = document.getElementById('story_language_frame');
        const translationLanguageFreelySelect = document.getElementById('translation_language_freely');
        const translationLanguageFrameSelect = document.getElementById('translation_language_frame');

        languages.forEach((language) => {
          const option = document.createElement('option');
          option.value = language.code;
          option.text = language.name;

          storyLanguageFreelySelect.add(option.cloneNode(true));
          translationLanguageFreelySelect.add(option.cloneNode(true));
          storyLanguageFrameSelect.add(option.cloneNode(true));
          translationLanguageFrameSelect.add(option.cloneNode(true));
        });
      });
  }
  
  loadLanguages();

  function handleResponse(result, successMessage) {
    console.log("Result in handleResponse:", result);
  
    if (result && result.success) {
      alert(successMessage);
      form.reset();
      freelyEditor.setContents([{ insert: '' }]);
      block1Editor.setContents([{ insert: 'Once upon a time...\n\n' }, { insert: 'And everyday...\n\n' }, { insert: 'But one day...\n' }]);
      block2Editor.setContents([{ insert: 'And because of that...\n\n' }, { insert: 'And because of that...\n\n' }, { insert: '... (how many events are needed)\n' }]);
      block3Editor.setContents([{ insert: 'Until finally...\n\n' }, { insert: 'And since then...\n' }]);
      translationEditorFreely.setContents([{ insert: '' }]);
      translationEditorFrame.setContents([{ insert: '' }]);
    } else {
      alert("There was an error submitting your story. Please try again.");
    }
  }
  
  submitFreely.addEventListener("click", async (event) => {
    console.log("submitFreely event listener called");
    event.preventDefault();
  
    const response = await submitForm("submit_story.php");
    handleResponse(response, "Your story has been submitted successfully.");
  });
  
  submitFrame.addEventListener("click", async (event) => {
    console.log("submitFrame event listener called");
    event.preventDefault();
  
    const response = await submitForm("submit_story.php");
    handleResponse(response, "Your story has been submitted and is ready to read.");
  });

  async function submitForm(actionURL) {
    const formData = new FormData(form);
    console.log(formDataToObject(formData));
    console.log("Form Data:", formDataToObject(formData));
  
    formData.set("story_text", freelyEditor.root.innerHTML);
    formData.set("block1", block1Editor.root.innerHTML);
    formData.set("block2", block2Editor.root.innerHTML);
    formData.set("block3", block3Editor.root.innerHTML);
    formData.set("translation_text_freely", translationEditorFreely.root.innerHTML);
    formData.set("translation_text_frame", translationEditorFrame.root.innerHTML);
  
    const storyLanguageFreely = document.getElementById("story_language_freely");
    const storyLanguageFrame = document.getElementById("story_language_frame");
    const translationLanguageFreely = document.getElementById("translation_language_freely");
    const translationLanguageFrame = document.getElementById("translation_language_frame");
  
    const inputMethod = document.querySelector('input[name="input_method"]:checked');

    formData.set("story_language_freely", storyLanguageFreely.value);
    formData.set("translation_language_freely", translationLanguageFreely.value);
    formData.set("story_language_frame", storyLanguageFrame.value);
    formData.set("translation_language_frame", translationLanguageFrame.value);
  
    try {
      const response = await fetch(actionURL, {
        method: "POST",
        body: formData,
      });
  
      const responseText = await response.text();
      console.log("Server response:", responseText);
      const result = JSON.parse(responseText);
      console.log("Parsed result:", result);
      return result; // Return the parsed JSON object
    } catch (error) {
      console.error("Error parsing JSON:", error);
      return null;
    }
  }
  
});

  /* Toggle the visibility of the translation fields when the checkbox is clicked
  function toggleTranslationFields(checkboxId, translationFieldsId) {
    document.getElementById(checkboxId).addEventListener("change", function () {
      let translationFields = document.getElementById(translationFieldsId);
      if (this.checked) {
        translationFields.style.display = "block";
      } else {
        translationFields.style.display = "none";
      }
    });
  }

  toggleTranslationFields("add_translation_freely", "translation_fields_freely");
  toggleTranslationFields("add_translation_frame", "translation_fields_frame");
  */



  
   /* if (!document.getElementById("add_translation_freely").checked) {
      formData.set("translation_text_freely", "");
    }
    
    if (!document.getElementById("add_translation_frame").checked) {
      formData.set("translation_text_frame", "");
    }
  */