<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>

<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6; padding: 5px',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; ;',
    'email-body_inner' => 'max-width: 100%; width: auto; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 15px; width: 500px; max-width: 1100%; background-color:#FFF;',

    'email-footer' => 'width: auto; max-width: 100%; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;background-color: #FFF;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; max-width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #155d8c;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #353535; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #353535; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #155d8c; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;max-width:100%;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #155d8c;',
];
?>

<?php $fontFamily = 'font-family: \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="{{ $style['email-wrapper'] }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">

                    <!-- Email Body -->
                    <tr>
                        <td style="{{ $style['email-body'] }}" width="100%">
                            <table style="{{ $style['email-body_inner'] }}" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                        
                                        <!-- Intro -->
                                        <p style="{{ $style['paragraph'] }}">
                                        Hi {{ $user->first_name }},
                                        </p>

                                        <!-- Outro -->
                                        <p style="{{ $style['paragraph'] }}">
                                            Welcome to Cloudstore Philippines. We are here to help small businesses in the Philippines grow without the technicalities of web development at a very fair price.
                                            <br /> <br />
                                            Click the button below to create your first store:
                                        </p>

                                        <!-- Action Button -->
                                        @if (isset($actionUrl))
                                            <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center">
                                                        <?php $actionColor = 'button--blue'; ?>

                                                        <a href="{{ $actionUrl }}"
                                                            style="{{ $fontFamily }} {{ $style['button'] }} {{ $style[$actionColor] }}"
                                                            class="button"
                                                            target="_blank">
                                                            {{ $actionText }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        <!-- Outro -->
                                        <p style="{{ $style['paragraph'] }}">
                                            If you have questions, suggestions, and other related concerns, please don't hesitate to contact us at: <br />
                                            Email: <a href="mailto:supprt@cloudstore.ph">support@cloudstore.ph</a> <br />
                                            Mobile: <strong>09162792651</strong> <br /><br />
                                            You can also reach us through our chat window on our website. <br /><br />

                                            Thanks, <br>Cloudstore Philippines
                                        </p>
    


                                        <table style="{{ $style['body_sub'] }}">
                                            <tr>
                                                <td style="{{ $fontFamily }}">
                                                    <p style="{{ $style['paragraph-sub'] }}">
                                                        If you’re having trouble clicking the "{{ $actionText }}" button,
                                                        copy and paste the URL below into your web browser:
                                                    </p>
                                                    <p style="{{ $style['paragraph-sub'] }}">
                                                        <a style="{{ $style['anchor'] }}" href="{{ $actionUrl }}" target="_blank">
                                                            {{ $actionUrl }}
                                                        </a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <br/>
                                        <table style="padding: 8px 14px; background-color: #eee; width: 100%">
                                            <tr>
                                                <td style="{{ $fontFamily }}font-size: 11px">
                                                    <a style="{{ $style['anchor'] }}text-decoration: none; margin-right: 14px" href="{{ route('manager.pricing') }}">Pricing</a>
                                                    <a style="{{ $style['anchor'] }}text-decoration: none" href="{{ route('manager.support') }}">Support</a>
                                                </td>
                                                <td style="{{ $fontFamily }}text-align: right;">
                                                    <a style="{{ $style['anchor'] }}text-decoration: none; margin-right: 14px" href="https://www.facebook.com/cloudstorephilippines/"><img src="http://www.cloudstore.ph/images/facebook-icon.png" style="height: 12px"></a>
                                                    <a style="{{ $style['anchor'] }}text-decoration: none; margin-right: 14px" href="https://twitter.com/cloudstore_ph"><img src="http://www.cloudstore.ph/images/twitter-icon.png" style="height: 12px"></a>
                                                    <a style="{{ $style['anchor'] }}text-decoration: none;" href="https://www.instagram.com/cloudstorephilippines/"><img src="http://www.cloudstore.ph/images/instagram-icon.png" style="height: 12px"></a>
                                                </td>
                                            </tr>
                                        </table>
                                        <table style="padding-top: 14px; width: 100%">
                                            <tr>
                                                <td style="text-align: center; font-size: 11px; vertical-align: middle;">
                                                    &copy; Copyright 2017 | <strong><a href="http://www.cloudstore.ph/" style="color: #333; text-decoration: none">Cloudstore Philippines</a></strong>
                                                </td>
                                            </tr>
                                        </table>
    
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
