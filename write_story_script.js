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
    

    function updateInputMethodVisibility() {
      const freelyVisible = inputMethodFreely.checked;
      freelyContainer.style.display = freelyVisible ? "block" : "none";
      freelyContainer.style.visibility = freelyVisible ? "visible" : "hidden";
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
    
  inputMethodFreely.addEventListener("change", updateInputMethodVisibility);
  inputMethodStorytelling.addEventListener("change", updateInputMethodVisibility);

  updateInputMethodVisibility();


  function formDataToObject(formData) {
    const data = {};
    for (const [key, value] of formData.entries()) {
      data[key] = value;
    }
    return data;
  }
  
  
  function handleFreelyResponse(response) {
    if (response && response.ok) {
      alert("Your story has been submitted successfully.");
      form.reset();
      freelyEditor.setContents([{ insert: '' }]);
    } else {
      alert("There was an error submitting your story. Please try again.");
    }
  }
  
  function handleFrameResponse(response) {
    if (response && response.ok) {
      alert("Your story has been submitted and is ready to read.");
      form.reset();
      block1Editor.setContents([{ insert: 'Once upon a time...\n\n' }, { insert: 'And everyday...\n\n' }, { insert: 'But one day...\n' }]);
      block2Editor.setContents([{ insert: 'And because of that...\n\n' }, { insert: 'And because of that...\n\n' }, { insert: '... (how many events are needed)\n' }]);
      block3Editor.setContents([{ insert: 'Until finally...\n\n' }, { insert: 'And since then...\n' }]);
    } else {
      alert("There was an error submitting your story for reading. Please try again.");
    }
  }
  
  submitFreely.addEventListener("click", async (event) => {
    console.log("submitFreely event listener called");
    event.preventDefault();

    const response = await submitForm("submit_story.php");
    handleFreelyResponse(response);
  });

  submitFrame.addEventListener("click", async (event) => {
    console.log("submitFrame event listener called");
    event.preventDefault();

    const response = await submitForm("submit_story.php");
    console.log("After getting submit-frame element:", submitFrame);

    handleFrameResponse(response);

  });

  async function submitForm(actionURL) {
    const formData = new FormData(form);
    console.log(formDataToObject(formData));
  
    console.log("Form Data:", formDataToObject(formData));

    formData.set("story_text", freelyEditor.root.innerHTML);
    formData.set("block1", block1Editor.root.innerHTML);
    formData.set("block2", block2Editor.root.innerHTML);
    formData.set("block3", block3Editor.root.innerHTML);
  
    const response = await fetch(actionURL, {
      method: "POST",
      body: formData,
    });
  
    const responseText = await response.text();
  
    try {
      const jsonResponse = await JSON.parse(responseText);
      console.log("Response status:", response.status);
      console.log("Response JSON:", jsonResponse);
  
      return response;
    } catch (error) {
      console.error("Error parsing JSON:", error);
      return null;
    }
  }
    


});



