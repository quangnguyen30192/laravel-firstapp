# Email



## Email API: mailgun

* Signup mailgun



* Installing mail driver

  ```
  composer require guzzlehttp/guzzle
  ```

  

* Update your `.env`

  ```
  MAIL_DRIVER=mailgun
  MAILGUN_DOMAIN=sandboxf3c2afc7a2da4053ae192b6cd0bd4ca3.mailgun.org
  MAILGUN_SECRET=private-mailgun-key
  MAIL_FROM_ADDRESS=quang@nguyen.com
  MAIL_FROM_NAME=quangnguyen
  ```



* Sending very simple email

  ```php
  Mail::raw('test', function ($message) {
      $message->to('quangnbnse90114@gmail.com', 'Quang')->subject('Hello Quang how are you');
  });
  ```

  if there is error about guzzle package: check Client.php(guzzle/src) - configureDefaults - verify -> false

* Docs: https://laravel.com/docs/5.2/mail

