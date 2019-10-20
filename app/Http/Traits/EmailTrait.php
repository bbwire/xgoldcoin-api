<?php


namespace App\Http\Traits;


trait EmailTrait
{

    public function accountVerificationMail ($to, $subject, $name, $link) {

        $messageBody = '
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Future Options Consulting</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body style="margin: 0; padding: 10px; background: #efefef;">
        ';

        $messageBody .= '
            <div style="background: #ffffff; padding: 20px; border-top: 5px solid #333333; width: 70%; margin: 50px auto;">
                <h2>Future Options Consulting Account Creation</h2>
                <p>
                    Hi '. $name .', thank you for creating an account with <strong>Future Options Consulting</strong>. 
                 </p>
                 <p>
                    Please follow <a href=" '. $link . '">this link</a> to verify your account.
                </p>
             </div>
        ';

        $messageBody .= '                        
                        </body>
                    </html>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: Future Options Consulting Ltd <info@futureoptions.org>' . "\r\n";
        // $headers .= 'Cc: knandanan@gmail.com' . "\r\n";

        mail($to, $subject, $messageBody, $headers);

    }

    public function passwordRecoveryMail ($name, $to, $link)
    {
         $messageBody = '
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>Future Options Consulting</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body style="margin: 0; padding: 10px; background: #efefef;">
        ';

        $messageBody .= '
            <div style="background: #ffffff; padding: 20px; border-top: 5px solid #333333; width: 70%; margin: 50px auto;">
                <h2>Future Options Consulting Password Recovery</h2>
                <p>
                    Hello '. $name .', thank you for creating an account with <strong>Future Options Consulting</strong>. 
                 </p>
                 <p>
                    Please follow <a href=" '. $link . '">this link</a> to reset your password.
                </p>
             </div>
        ';

        $messageBody .= '                        
                        </body>
                    </html>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: Future Options Consulting Ltd <info@futureoptions.org>' . "\r\n";

        mail($to, 'Password recovery', $messageBody, $headers);
    }

}
