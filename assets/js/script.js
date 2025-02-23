document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-button").forEach(button => {
        button.addEventListener("click", function () {
            const postId = this.dataset.postId;
            const likeCount = this.querySelector(".like-count");

            // Prevent multiple clicks
            if (this.classList.contains("processing")) return;
            this.classList.add("processing");

            fetch("like_post.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "liked") {
                    this.classList.add("liked");
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                } else if (data.status === "unliked") {
                    this.classList.remove("liked");
                    likeCount.textContent = parseInt(likeCount.textContent) - 1;
                }
            })
            .catch(error => console.error("Error:", error))
            .finally(() => {
                this.classList.remove("processing"); // Allow next click after response
            });
        });
    });
});
document.getElementById("upload-banner-form").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // Manually set the upload directory in FormData
    formData.append("upload_dir");
    formData.append("upload_dir", "/uploads/");

    fetch("upload_banner.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log("Upload Response:", data);
        location.reload(); // Refresh page to show new banner
    })
    .catch(error => console.error("Error:", error));
});
