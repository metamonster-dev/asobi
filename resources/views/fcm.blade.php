<html>
    <head>
        <title>fcm 테스트 페이지</title>
    </head>
    <body>
        <script type="module">
            // Import the functions you need from the SDKs you need
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-app.js";
            import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-messaging.js";

            // TODO: Add SDKs for Firebase products that you want to use
            // https://firebase.google.com/docs/web/setup#available-libraries

            // Your web app's Firebase configuration
            const firebaseConfig = {
                apiKey: "AIzaSyBYsMF8gK7M3pwaYh_91YNAbEikD6mO8h4",
                authDomain: "new-asobi.firebaseapp.com",
                projectId: "new-asobi",
                storageBucket: "new-asobi.appspot.com",
                messagingSenderId: "993994681272",
                appId: "1:993994681272:web:1c0c76c9f34e99a3adfd4d"
            };

            // Initialize Firebase
            const app = initializeApp(firebaseConfig);

            // const analytics = getAnalytics(app);
            const messaging = getMessaging(app);

            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                } else {
                    console.log('Unable to get permission to notify.');
                }
            });

            //토큰값 얻기
            getToken(messaging, {
                vapidKey:
                "BM5W-ud1mt4im-BrbITZi1BldfzwZepiraqrnwO3QR-S6LsC-hcQL1HXJ96mFFjY63usK3dbDOFNUWM8SvxL8Ug",
            })
            .then((currentToken) => {
                if (currentToken) {
                    // Send the token to your server and update the UI if necessary
                    // ...
                    console.log('currentToken:');
                    console.log(currentToken);
                } else {
                    // Show permission request UI
                    console.log(
                        "No registration token available. Request permission to generate one."
                    );
                    // ...
                }
            })
            .catch((err) => {
                console.log("An error occurred while retrieving token. ", err);
                // ...
            });

            //포그라운드 메시지 수신
            onMessage(messaging, (payload) => {
                console.log("Message received. ", payload);
                // new Notification(payload.notification.title, {body:payload.notification.body});
                // let li = "<li><dl><dt>"+payload.notification.title+"</dt><dd>"+payload.notification.body+"</dd></dl></li>";
                // $("#push_list").append(li);
                // $("#noti-icon").removeClass("mdi-bell-outline").addClass("mdi-bell-alert").addClass("co_R")
                // ...
            });
        </script>
    </body>
</html>
