async function fetchFollowings() {
    try {
        const response = await fetch('/api/followings', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
        });

        if (!response.ok) {
            throw new Error('Failed to fetch followings');
        }

        return await response.json();
    } catch (error) {
        console.error('Error fetching followings:', error.message);
        throw new Error('Failed to fetch followings');
    }
}

async function fetchPostsFromFollowedUsers(userId) {
    try {
        const response = await fetch(`/api/posts/followed-users?userId=${userId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
        });

        if (!response.ok) {
            throw new Error('Failed to fetch posts from followed users');
        }

        return await response.json();
    } catch (error) {
        console.error('Error fetching posts from followed users:', error.message);
        throw new Error('Failed to fetch posts from followed users');
    }
}
