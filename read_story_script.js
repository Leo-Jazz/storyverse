function nl2br(str) {
    return (str + '').replace(/(\r\n|\n\r|\r|\n)/g, '<br>$1');
}

window.addEventListener('DOMContentLoaded', () => {
    const storyTitles = document.querySelectorAll('.story-title');
    const storyContent = document.querySelector('.story-content');
    const storyDataContainer = document.querySelector('.story-data');

    storyTitles.forEach(title => {
        title.addEventListener('click', async () => {
            const id = title.getAttribute('data-id');
            const response = await fetch(`get_story.php?id=${id}`);
            const storyData = await response.json();

            document.getElementById("comments-list").innerHTML = "";
            document.querySelector(".like-button").disabled = false;

            if (storyData.success) {
              const { story_name, author_name, story_text, translation_text, images, likes, comments, story_language, translation_language } = storyData;

              let imagesHTML = '';
              if (images.length) {
                imagesHTML = '<h3>Images:</h3>';
                images.forEach(image => {
                  imagesHTML += `<img src="${image}" alt="Story image">`;
                });
              }

              storyDataContainer.innerHTML = `
                <h2>${story_name}</h2>
                <h3>by ${author_name}</h3>
                ${imagesHTML}
                <p>${nl2br(story_text)}</p>
              `;

              storyDataContainer.setAttribute('data-original-text', storyDataContainer.innerHTML);

              if (translation_text) {
                storyDataContainer.setAttribute(
                    'data-translated-text',
                    `<h2>${story_name}</h2><h3>by ${author_name}</h3><p>${nl2br(translation_text)}</p>${imagesHTML}`
                );
                console.log('Translation text:', nl2br(translation_text)); // Add this line
                storyDataContainer.setAttribute('data-original-language', story_language);
                storyDataContainer.setAttribute('data-translation-language', translation_language);
                document.querySelector('#language-switcher').textContent = translation_language; // Corrected this line
                document.querySelector('#language-switcher').classList.remove('hidden');
              } else {
                  storyDataContainer.removeAttribute('data-translated-text');
                  document.querySelector('#language-switcher').classList.add('hidden');
              }
              document.querySelector(".like-button-container").classList.remove("hidden");
              document.querySelector(".comment-section").classList.remove("hidden");
            }
        });
    });

    const storyId = new URLSearchParams(window.location.search).get('id');
    if (storyId) {
        const targetStoryTitle = document.querySelector(`.story-title[data-id="${storyId}"]`);
        if (targetStoryTitle) {
            targetStoryTitle.click();
        }
    }

    document.getElementById("comment-form").addEventListener("submit", async function (event) {
        event.preventDefault();
        const commentText = document.getElementById("comment-text").value;
        const storyId = document.getElementById("like-count").getAttribute("data-story-id");
      
        if (commentText.trim() && await submitComment(storyId, commentText)) {
          const commentElement = document.createElement("div");
          commentElement.className = "comment";
          commentElement.textContent = commentText;
          document.getElementById("comments-list").appendChild(commentElement);
          document.getElementById("comment-text").value = "";
        }
    });


});

async function handleLikeClick(button) {
    button.disabled = true;
    const likeCountElement = document.getElementById("like-count");
    const storyId = likeCountElement.getAttribute("data-story-id");
    let likeCount = parseInt(likeCountElement.textContent.trim(), 10);
    likeCount += 1;
  
    const newLikeCount = await submitLike(storyId, likeCount);
    if (newLikeCount !== null) {
      likeCountElement.textContent = newLikeCount;
    }
    
}

async function submitLike(storyId, likeCount) {
  const response = await fetch("submit_comments.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `storyId=${storyId}&likes=${likeCount}`,
  });
  
  const data = await response.json();
  return data.success ? likeCount : null;
}

async function submitComment(storyId, commentText) {
  const response = await fetch("submit_comments.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `storyId=${storyId}&comment=${encodeURIComponent(commentText)}`,
  });
  
  const data = await response.json();
  return data.success;
}

function switchLanguage() {
  const storyData = document.querySelector('.story-data');
  const originalText = storyData.getAttribute('data-original-text');
  const translatedText = storyData.getAttribute('data-translated-text');
  const currentText = storyData.innerHTML;

  const originalLanguage = storyData.getAttribute('data-original-language');
  const translationLanguage = storyData.getAttribute('data-translation-language');
  const languageSwitcher = document.querySelector('#language-switcher');

  if (currentText === originalText) {
      storyData.innerHTML = translatedText;
      languageSwitcher.textContent = originalLanguage;
  } else {
      storyData.innerHTML = originalText;
      languageSwitcher.textContent = translationLanguage;
  }
}
