const pusherAppKey = 'da80c91c23404a2f4cfd';
const pusherCluster = 'eu';

const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    debug: true // TODO remove this
});
const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
const channel = pusher.subscribe(`private-user.${userId}`);
// channel.bind('notification-postlike', function(data) {
//     console.log(data);
// });
console.log("Subscribed to private-user." + userId);
channel.bind('notification-comment', function(data) {
    console.log(data);
    alert(data);
});
// channel.bind('notification-group-request', function(data) {
//     console.log(data);
// });
// channel.bind('notification-group-join', function(data) {
//     console.log(data);
// });
// channel.bind('notification-tag', function(data) {
//     console.log(data);
// });
