package androidfanatic.fcmdemo;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;
import com.google.firebase.messaging.FirebaseMessaging;

public class DemoIdService extends FirebaseInstanceIdService {

    @Override public void onTokenRefresh() {
        super.onTokenRefresh();
        String token = FirebaseInstanceId.getInstance().getToken();
        FirebaseMessaging.getInstance().subscribeToTopic("default");
        System.out.println("FCM token: " + token);
    }
}
