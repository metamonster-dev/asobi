// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
importScripts('https://www.gstatic.com/firebasejs/9.19.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.19.1/firebase-messaging-compat.js');

const config = {
    apiKey: "AIzaSyBYsMF8gK7M3pwaYh_91YNAbEikD6mO8h4",
    authDomain: "new-asobi.firebaseapp.com",
    projectId: "new-asobi",
    storageBucket: "new-asobi.appspot.com",
    messagingSenderId: "993994681272",
    appId: "1:993994681272:web:1c0c76c9f34e99a3adfd4d"
};

// Initialize Firebase
firebase.initializeApp(config);
const messaging = firebase.messaging();
//백그라운드 서비스워커 설정
// messaging.onBackgroundMessage((payload) => {
//     console.log(
//         "[firebase-messaging-sw.js] Received background message ",
//         payload
//     );
//
//     // Customize notification here
//     const notificationTitle = "Background Message Title";
//     const notificationOptions = {
//         body: payload,
//         icon: "/firebase-logo.png",
//     };
//
//     self.registration.showNotification(notificationTitle, notificationOptions);
// });
