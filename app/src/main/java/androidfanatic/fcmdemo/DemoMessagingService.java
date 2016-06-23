package androidfanatic.fcmdemo;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.RingtoneManager;
import android.support.v4.app.NotificationCompat;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.Map;

public class DemoMessagingService extends FirebaseMessagingService {

    private static int count = 0;
    private int notificationIcon = R.mipmap.ic_launcher;

    @Override public void onMessageReceived(RemoteMessage remoteMessage) {

        super.onMessageReceived(remoteMessage);

        NotificationManager notificationManager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
        Intent gotoIntent = new Intent(this, MainActivity.class);
        PendingIntent contentIntent = PendingIntent.getActivity(getApplicationContext(), (int) (Math.random() * 100), gotoIntent, PendingIntent.FLAG_UPDATE_CURRENT);


        if (remoteMessage.getNotification() != null) {

            // Notification

            Notification notification = new NotificationCompat.Builder(this)
                    .setSmallIcon(R.mipmap.ic_launcher)
                    .setContentText(remoteMessage.getNotification().getBody())
                    .setContentTitle(remoteMessage.getNotification().getTitle())
                    .setContentIntent(contentIntent)
                    .setAutoCancel(true)
                    .setSound(RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION))
                    .build();


            notificationManager.notify(count++, notification);

        } else {
            Map<String, String> data = remoteMessage.getData();

            for (String key : data.keySet()) {
                System.out.print(key);
                System.out.print(":");
                System.out.println(data.get(key));

            }


            String title = data.get("title");
            String body = data.get("body");
            String image = data.get("image");

            // Data message with image

            for (String key : remoteMessage.getData().keySet()) {
                System.out.print(key);
                System.out.print(" = ");
                System.out.print(remoteMessage.getData().get(key));
                System.out.println("");
            }

            NotificationCompat.BigPictureStyle notiStyle = new NotificationCompat.BigPictureStyle();
            notiStyle.setBigContentTitle(title);
            notiStyle.setSummaryText(body);

            Bitmap remote_picture;
            try {
                remote_picture = BitmapFactory.decodeStream((InputStream) new URL(image).getContent());
                notiStyle.bigPicture(remote_picture);
            } catch (IOException e) {
                e.printStackTrace();
            }

            Notification notification = new NotificationCompat.Builder(this)
                    .setSmallIcon(R.mipmap.ic_launcher)
                    .setAutoCancel(true)
                    .setStyle(new NotificationCompat.BigTextStyle().bigText(body))
                    .setContentIntent(contentIntent)
                    .setSound(RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION))
                    .setContentText(body)
                    .setStyle(notiStyle).build();


            notification.flags = Notification.FLAG_AUTO_CANCEL;
            notificationManager.notify(count++, notification);

        }
    }

}