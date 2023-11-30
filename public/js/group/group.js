// Path: public/js/group/group.js

function togglePostsMembers() {
    const posts = document.getElementById('posts');
    const members = document.getElementById('members');

    const posts_section = document.getElementById('posts-section');
    const members_section = document.getElementById('members-section');

    posts.addEventListener('click', () => {
        posts_section.classList.remove('hidden');
        members_section.classList.add('hidden');
    });

    members.addEventListener('click', () => {
        posts_section.classList.add('hidden');
        members_section.classList.remove('hidden');
    });
}

togglePostsMembers();