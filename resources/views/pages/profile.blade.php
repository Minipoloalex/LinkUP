<!-- resources/views/user/profile.blade.php -->

@extends('layouts.app')

@section('title', 'profile-page')

@section('profile-page')
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>

        @vite('resources/css/app.css')
    </head>

    <body>
        <main>
        <div class="columns">
            <div class="column-1">
                <ul>
                    <li>Home</li>
                    <li>Profile</li>
                    <li>MyNetwork</li>
             
                    <li>About us</li>
                    <li>Support</li>
                   
                </ul>
            </div>
            <div class="column-2">
                <div class= "profile">
                    <div class="edit-profile">
                        <button type="button" class="edit-button">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div id="myModal" class="modal">
                    <!-- Modal content to edit profile -->
                    <!-- Modal content to edit profile -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form id="editForm">
                            <label for="editName">Name:</label>
                            <input type="text" id="editName" name="editName" value="John Doe" required>

                            <label for="editUsername">Username:</label>
                            <input type="text" id="editUsername" name="editUsername" value="johndoe" required>

                            <label for="editPhoto">Profile Photo URL:</label>
                            <input type="url" id="editPhoto" name="editPhoto" value="https://i.pinimg.com/originals/9b/47/a0/9b47a023caf29f113237d61170f34ad9.jpg" required>


                            <button type="submit">Save Changes</button>
                        </form>
                    </div>

                    </div>
                    <img class="profile-image" src="https://i.pinimg.com/originals/9b/47/a0/9b47a023caf29f113237d61170f34ad9.jpg" alt="Profile Photo">
                    <div class="name-username">
                        <p>John Doe</p>
                        <p>@johndoe</p>
                    </div>
                    <div class="profile-numbers">
                        <div>
                            <p>Followers</p>
                            <p>3</p>
                        </div>
                        <div>
                            <p>Following</p>
                            <p>3</p>
                        </div>
                        <div>
                            <p>Groups</p>
                            <p>3</p>
                        </div>

                    
                    </div>
                    <div class ="bio">
                        <p>
                            <!-- generate a random bio -->
                            Lorem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
                <div class="post">
                    <div class="post-header">
                        <img src="https://i.pinimg.com/originals/9b/47/a0/9b47a023caf29f113237d61170f34ad9.jpg" alt="Profile picture" class="profile-picture">
                        <div class="post-info">
                            <span class="post-username">John Doe</span>
                            <span class="post-timestamp">2 hours ago</span>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>This is a social media post.</p>
                        <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg" alt="Post image" class="post-image">
                    </div>
                    <div class="post-footer">
                        <div class="post-actions">
                            <button class="post-action"><i class="fa-solid fa-heart"></i></button>
                            <button class="post-action">
                                <i class="fa-solid fa-comment" ></i>
                            </button>
                        </div>
                        <form class="write-comment">
                            <label for="comment">Comment:</label>
                            <textarea id="comment" name="comment" rows="5" cols="50" required></textarea>
                            <br>
                            <button type="submit">Submit Comment</button>
                        </form>

                        <div class="post-comments">
                            <div class="comment">
                            <img src="commenter-picture.jpg" alt="Commenter picture" class="commenter-picture">
                            <div class="comment-info">
                                <span class="comment-username">Jane Doe</span>
                                <span class="comment-timestamp">1 hour ago</span>
                            </div>
                            <p class="comment-text">This is a comment.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="column-3">
                <div>
                    Content 4
                </div>
            </div>
            </main>

            <script>
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
        </script>
    </body>
</html>
@endsection
