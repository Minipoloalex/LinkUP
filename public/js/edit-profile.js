document.addEventListener("DOMContentLoaded", function () {
                var modal = document.getElementById("myModal");
                var btn = document.querySelector(".edit-button");
                var closeBtn = document.querySelector(".close");
                var editForm = document.getElementById("editForm");

                // Open the modal
                btn.addEventListener("click", function () {
                    modal.style.display = "block";
                    document.body.style.overflow = "hidden"; // Disable scrolling on the background
                });

                // Close the modal
                closeBtn.addEventListener("click", function () {
                    modal.style.display = "none";
                    document.body.style.overflow = "auto"; // Enable scrolling on the background
                });

                // Handle form submission
                editForm.addEventListener("submit", function (event) {
                    event.preventDefault();

                    // Get the edited values
                    var newName = document.getElementById("editName").value;
                    var newUsername = document.getElementById("editUsername").value;
                    var newPhoto = document.getElementById("editPhoto").value;

                    // Update the displayed information
                    document.querySelector(".name-username p:first-child").innerText = newName;
                    document.querySelector(".name-username p:last-child").innerText = "@" + newUsername;
                    document.querySelector(".profile-image").src = newPhoto;

                    // Close the modal
                    modal.style.display = "none";
                    document.body.style.overflow = "auto"; // Enable scrolling on the background
                });

                // Close the modal when clicking outside of it
                window.addEventListener("click", function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        document.body.style.overflow = "auto"; // Enable scrolling on the background
                    }
                });
            });

console.log("edit-profile.js loaded");