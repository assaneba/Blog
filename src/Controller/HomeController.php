<?php

namespace Controller;

class HomeController extends Controller
{

    public function index()
    {
        $page = $this->twig->render('home.html.twig');
        $this->viewPage($page);
    }

    public function login()
    {
        $page = $this->twig->render('login.html.twig');
        $this->viewPage($page);
    }

    public function register()
    {
        $page = $this->twig->render('register.html.twig');
        $this->viewPage($page);
    }

    public function sendMail()
    {
        // Check for empty fields
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone');
        $message = filter_input(INPUT_POST, 'message');

        if(empty($name) || empty($email) || empty($phone) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(500);
        }
        // Create the email and send the message
        $subject = "Website Contact Form - email from:  $name";
        $body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nPhone: $phone\n\nMessage:\n$message";
        $header = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $header .= "reply-to: $email";
        if(!mail(EMAIL_TO, $subject, $body, $header))
            http_response_code(500);
        $this->message = 'Votre mail a été bien envoyé';
        $this->index();
    }

}