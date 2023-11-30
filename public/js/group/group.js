// Path: public/js/group/group.js
const Swal = window.swal;

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

function removeMember(group, member_id, member) {
    const url = `/group/${group}/member/${member_id}`;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(data => {
        if (data.status === 200) {
            member.remove();
        }
    })
    .catch(error => console.error(error));
}


function addRemoveMemberEvents() {
    const group = document.getElementById('group-id').value;
    const members = document.querySelectorAll('#members-section > div');
    if (!members) return;
    
    for (const member of members) {
        const name = member.querySelector('h1').textContent;
        const button = member.querySelector('.member-remove');
        const member_id = button.id;
        
        button.addEventListener('click', () => {
            Swal.fire({
                title: `Remove ${name}?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, remove.'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Removed!',
                        `${name} has been removed.`,
                        'success'
                    )
                    removeMember(group, member_id, member);
                }
            })
        });
    }
}
    
togglePostsMembers();
addRemoveMemberEvents();