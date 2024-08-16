function subscribeToPushNotifications() {
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('Service Worker registered');
                return registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array('YOUR_PUBLIC_VAPID_KEY')
                });
            })
            .then(function(subscription) {
                // Send the subscription details to your server
                return fetch('save-subscription.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(subscription),
                });
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Bad status code from server.');
                }
                return response.json();
            })
            .then(function(responseData) {
                if (!(responseData.data && responseData.data.success)) {
                    throw new Error('Bad response from server.');
                }
                console.log('Push notification subscription successful');
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
    }
}

// Function to convert base64 to Uint8Array (keep this unchanged)
function urlBase64ToUint8Array(base64String) {
    // ... (keep the existing implementation)
}

// Call this function when the page loads
window.addEventListener('load', subscribeToPushNotifications);