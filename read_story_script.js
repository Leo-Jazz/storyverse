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
                const { story_name, author_name, story_text, images, likes, comments } = storyData;
              
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
                  <p>${nl2br(story_text)}</p>
                  ${imagesHTML}
                `;
                document.getElementById("like-count").textContent = likes;
                document.getElementById("like-count").setAttribute("data-story-id", id);
              
                const commentsList = document.getElementById("comments-list");
                commentsList.innerHTML = "";
                comments.forEach(comment => {
                  const commentElement = document.createElement("div");
                  commentElement.className = "comment";
                  commentElement.textContent = comment.comment_text;
                  commentsList.appendChild(commentElement);
                });
              } else {
                storyDataContainer.innerHTML = '<p>Error loading story.</p>';
              }
              

            document.querySelector(".like-button-container").classList.remove("hidden");
            document.querySelector(".comment-section").classList.remove("hidden");
            
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

