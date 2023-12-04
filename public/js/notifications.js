const pusherAppKey = 'da80c91c23404a2f4cfd';
const pusherCluster = 'eu';
function getUserId() {
    const element = document.querySelector('meta[name="user-id"]');
    if (element) {
        return element.getAttribute('content');
    }
    return null;
}
const userId = getUserId();
if (userId) {
    Pusher.logToConsole = true; // TODO remove this for production
    const pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster,
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        debug: true // TODO remove this for production
    });
    const channel = pusher.subscribe(`private-user.${userId}`);
    channel.bind('notification-comment', function(data) {
        console.log("Received notification-comment");
        console.log(data);
    });
    channel.bind('notification-followrequest', function(data) {
        console.log("Received notification-followrequest");
        console.log(data);
    });
    channel.bind('notification-postlike', function(data) {
        console.log(data);
    });
    channel.bind('notification-group', function(data) {
        console.log(data);
    });
    // channel.bind('notification-tag', function(data) {
    //     console.log(data);
    // });
}
