document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const contentId = this.getAttribute("data-id");
            const contentType = this.getAttribute("data-type");

            if (!confirm("Are you sure you want to delete this " + contentType + "?")) return;

            fetch("delete_content.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `content_id=${contentId}&type=${contentType}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Content deleted successfully!");
                    location.reload();
                } else {
                    alert("❌ Error: " + data.error);
                }
            })
            .catch(error => console.error("Error deleting content:", error));
        });
    });
});
