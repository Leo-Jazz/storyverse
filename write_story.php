<?php $versions = json_decode(file_get_contents('versions.json'), true); ?>

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

  <title>Write Your Story | Storyverse</title>
  
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  
</head>

<body>
  <header> <?php include 'header.php'; ?> </header>
  <div class="title-container">
    <h1>Write Your Story</h1>
    <p>Choose the way you would like to write your story:</p>
  </div>
    <div class="input-method-container">  
      <div class="input-method">
        <input type="radio" id="input_method_freely" name="input_method" checked>
        <label for="input_method_freely">
          <h3>Freely write your story</h3>
          <p>Just type your story or paste it from your favorite text editor. If you have illustrations or pictures for the story, you can upload them also to make an even richer experience for the readers. When you submit, people will be able to read your story the way you post here!</p>
        </label>
      </div>
      <div class="input-method">
        <input type="radio" id="input_method_storytelling" name="input_method">
        <label for="input_method_storytelling">
          <h3>Write with a basic storytelling framework</h3>
          <p>Here you have some the support of a basic storytelling framework, with building blocks to think about the story and suggestions for a smooth progression to help you write with a little bit of storytelling technique. We are using the 4 x 4 frame by author Joni Galvão. You can also upload your illustrations and pictures here! Have fun!</p>
        </label>
      </div>
    </div>

    <form id="write-story-form" enctype="multipart/form-data">
      <div id="freely-container">
      <!-- Freely form goes here -->
        <div>
          <label for="author_name">Author Name:</label>
          <input type="text" name="author_name" id="author_name" required>
        </div>
        <div>
          <label for="story_name">Story Name:</label>
          <input type="text" name="story_name" id="story_name" required>
        </div>
        <!-- Language Selection -->
        <div>
          <label for="story_language_freely">Select story original language:</label>
          <select id="story_language_freely" name="story_language" required>
            <!-- Add language options from languages.json -->
          </select>
        </div>
          <label for="story_text">Story Text:</label>
          <div class="quill-editor" id="story_text"></div>
        <div>
          <label for="story_images">Ilustrate your story, upload images or ilustrations to represent your story:</label>
          <input type="file" name="story_images[]" id="story_images" accept="image/*" multiple>
        </div>
        <input type="hidden" name="input_method" value="freely">
        
        <!-- Option to add a Translation
        <div>
          <label for="add_translation_freely">Include a translation:</label>
          <input type="checkbox" id="add_translation_freely" name="add_translation">
        </div>
         -->
        <h3>Would you like to add a translation for your story?</h2>
        <p>You can write a translation to your story in the Text Editor below if you wish. It might help to broaden your story´s audience. You can get a little help online to speed up translation:</p>
        <ul>
          <li><a href="https://translate.google.com/" target="_blank">Google Translate</a></li>
          <li><a href="https://www.deepl.com/translator" target="_blank">DeepL</a></li>
          <li><a href="https://chat.openai.com/" target="_blank">Chat GPT</a></li>
        </ul>

        <div id="translation_fields_freely">
          <div>
            <label for="translation_language_freely">Select translation language:</label>
            <select id="translation_language_freely" name="translation_language">
              <!-- Add language options from languages.json -->
            </select>
          </div>
          <div>
            <label for="translation_text_frrely">Add a translation for your story:</label>
            <div class="quill-editor" id="translation_text_freely"></div>
          </div>
        </div>
        <!-- Submit Story button Freely method-->
        <button type="submit" id="submit-freely" class="button">Submit Story</button>
      </div>

      <div id="frame-container" style="display: none;">
        <!-- Frame form goes here -->
        <div>
          <label for="author_name">Author Name:</label>
          <input type="text" name="author_name" id="author_name" required>
        </div>
        <div>
          <label for="story_name">Story Name:</label>
          <input type="text" name="story_name" id="story_name" required>
        </div>
        <!-- Language Selection -->
        <div>
          <label for="story_language_frame">Select story original language:</label>
          <select id="story_language_frame" name="story_language" required>
            <!-- Add language options from languages.json -->
          </select>
        </div>
        
        <h2>Elements of the Story</h2>
        <!-- Add the fields for Core Idea, Universe, Main characters, and Antagonistic Forces -->
        <div>
          <label for="core_idea">Core Idea of the story:</label>
          <input type="text" name="core_idea" id="core_idea">
        </div>
        <div>
          <label for="universe">Universe of the story:</label>
          <input type="text" name="universe" id="universe">
        </div>
        <div>
          <label for="characters">Main characters description and their desires:</label>
          <input type="text" name="characters" id="characters">
        </div>
        <div>
          <label for="antagonistic_forces">Antagonistic forces (internal and/or external to the main character):</label>
          <input type="text" name="antagonistic_forces" id="antagonistic_forces">
        </div>
          <!-- Blocks -->
          <!-- Block 1 -->
          <h3>Block 1: Introduction, Context and Trigger Event</h3>
          <p>Introduce the universe, characters, and show how things used to happen before a trigger event puts our characters on the way of their transformation.</p>
          <div class="quill-editor" id="block1"></div>
  
          <!-- Block 2 -->
          <h3>Block 2: Progressive Complications</h3>
          <p>All the events leading to actions and reactions that will lead the characters' transformation along the story.</p>
          <div class="quill-editor" id="block2"></div>
  
          <!-- Block 3 -->
          <h3>Block 3: Ending</h3>
          <p>Climax and conclusion of the story: All events lead to a major event where the character needs to make a big decision to fulfill or not their biggest wishes and how things became after this major event.</p>
          <div class="quill-editor" id="block3"></div>
  
          <!-- Image upload for Input Method B -->
        <div>
        <label for="story_images_b">Ilustrate your story, upload images or ilustrations to represent your story:</label>          <label for="story_images_b">Upload images:</label>
        <input type="file" name="story_images[]" id="story_images_b" accept="image/*" multiple>
        </div>
        <input type="hidden" name="input_method" value="frame">

        <!-- Option to add a Translation
        <div>
          <label for="add_translation_freely">Include a translation:</label>
          <input type="checkbox" id="add_translation_freely" name="add_translation">
        </div>
         -->
        <h3>Would you like to add a translation for your story?</h2>
        <p>You can write a translation to your story in the Text Editor below if you wish. It might help to broaden your story´s audience. You can get a little help online to speed up translation:</p>
        <ul>
          <li><a href="https://translate.google.com/" target="_blank">Google Translate</a></li>
          <li><a href="https://www.deepl.com/translator" target="_blank">DeepL</a></li>
          <li><a href="https://chat.openai.com/" target="_blank">Chat GPT</a></li>
        </ul>
        <div id="translation_fields_frame">
          <div>
            <label for="translation_language_frame">Select translation language:</label>
            <select id="translation_language_frame" name="translation_language">
              <!-- Add language options from languages.json -->
            </select>
          </div>
          <div>
            <label for="translation_text_frame">Add a translation for your story:</label>
            <div class="quill-editor" id="translation_text_frame"></div>
          </div>
        </div> 
        <!-- Submit Story button Frame method-->
        <button type="button" id="submit-frame" class="button">Submit Story</button>
      </div>
    </form>
    
    <script defer src="write_story_script.js?v=<?php echo $cache_version; ?>" type="text/javascript"></script>
</body>
</html>