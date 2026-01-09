<?php

namespace app\modules\user\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class MailController extends Controller
{
    /**
     * Sends daily email to all users.
     * Command:
     * php yii user/mail/daily
     */
    public function actionDaily()
    {
        $users = User::find()->all();

        foreach ($users as $user) {
            try {
                $sent = Yii::$app->mailer
                    // ->compose('@app/modules/user/mail/daily', [
                    //     'user' => $user,
                    // ])
                    ->compose('daily', [
                        'user' => $user,
                    ])
                    ->setFrom(['no-reply@demomailtrap.co' => 'Admin'])
                    ->setTo($user->email)
                    ->setSubject('Daily New Notification')
                    ->send();   

                if ($sent) {
                    Yii::info(
                        "Email sent to {$user->email}",
                        'user-cron-success'
                    );
                } else {
                    Yii::error(
                        "Email failed for {$user->email}",
                        'user-cron-failed'
                    );
                }
            } catch (\Throwable $e) {
                Yii::error(
                    "Exception for {$user->email}: {$e->getMessage()}",
                    'user-cron-error'
                ); 
            }
        }
    }
}
