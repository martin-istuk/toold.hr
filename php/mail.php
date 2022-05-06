<?php
if (isset($_POST["email"])) {

    $name = $_POST["name"]; // required
    $email_adress_visitor = $_POST["email"]; // required
    $message = $_POST["message"]; // required
    $email_adress_admin = "toold@toold.hr";
    
    
    
    $email_subject_admin = "Nova poruka - toold.hr - " . $name;

    $email_message_admin .=
        "<html>
            <head>
                <style type='text/css'>
                    td {
                        padding: 15px;
                        vertical-align: top;
                    }
                    h6, p {
                        font-size: 16px;
                        padding: 2px;
                        margin: 0px;
                    }
                    h6 {
                        color: white;
                        background: black;
                        border-radius: 4px;
                    }
                    p {
                        padding-left: 15px;
                    }
                </style>
            </head>
            <body>
                <table style='width:100%'>
                    <colgroup>
                        <col style='width:100px'>
                    </colgroup>
                    <tr>
                        <td><h6>Ime:</h6></td>
                        <td><p>" . $name . "</p></td>
                    </tr>
                    <tr>
                        <td><h6>Email:</h6></td>
                        <td><p>" . $email_adress_visitor . "</p></td>
                    </tr>
                    <tr>
                        <td><h6>Poruka:</h6></td>
                        <td><p>" . $message . "</p></td>
                    </tr>
                </table>
            </body>
        </html>" . "\n";

    $email_headers_admin = "From: " . $email_adress_visitor . "\r\n" .
        "Reply-To: " . $email_adress_visitor . "\r\n" .
        "Content-Type: text/html; charset=UTF-8" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();
    
    @mail(
        $email_adress_admin,
        $email_subject_admin,
        $email_message_admin,
        $email_headers_admin
    );



    $email_subject_visitor = "Obavijest / Notification - toold.hr";

    $email_message_visitor .=
        "<html>
            <head>
                <style type='text/css'>
                    * {
                        font-family: Arial, Helvetica, sans-serif;
                    }
                    h6 {
                        font-size: 2.7vh;
                        margin: 1.8vh 0;
                    }
                    p, a {
                        font-size: 1.8vh;
                        margin: 0;
                        padding: 4px 0;
                    }
                    img {
                        height: 3.6vh;
                        padding-bottom: 1.8vh;
                    }
                </style>
            </head>
            <body>
                <h6>Obavijest</h6>
                <p>Zahvaljujemo na upitu. Odgovorit ćemo Vam u najkraćem mogućem roku.</p>
                <h6>Notification</h6>
                <p>Thanks for getting in touch. We'll get back to you soon.</p>
                <br>
                <hr>
                <br>
                <img src='https://toold.hr/img/logo-mail.jpg'>
                <br>
                <a href='toold.hr'>toold.hr</a>
                <p>Slavonska avenija 23, 10 040 Zagreb</p>
                <a href='mailto:toold@toold.hr'>toold@toold.hr</a>
                <p>+385 99 357 8558</p>
            </body>
        </html>" . "\n";

    $email_headers_visitor = "From: " . $email_adress_admin . "\r\n" .
        "Reply-To: " . $email_adress_admin . "\r\n" .
        "Content-Type: text/html; charset=UTF-8" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    @mail(
        $email_adress_visitor,
        $email_subject_visitor,
        $email_message_visitor,
        $email_headers_visitor
    );
}
    // INCLUDE YOUR SUCCESS MESSAGE BELOW

    echo
        "<div style='padding: 4rem;'>" .
            $email_message_visitor .
        "</div>" . "\n";
?>