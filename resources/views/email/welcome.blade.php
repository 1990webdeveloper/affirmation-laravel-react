@extends('email.layouts.master')
@section('content')
    <div style=" background-color: #f5f5f5">

        <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="600"
            style="width:600px;max-width:600px;margin: 0 auto;">
            <tr>
                <td style="line-height: 30px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <div class="site-logo">
                        <img src="./logo.svg" alt="Logo" style="width:180px" />
                    </div>
                </td>
            </tr>
            <tr>
                <td style="line-height: 30px;">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" bgcolor="#110e2a"
                    style="border-radius:36px;border-bottom:solid 6px #c4fd4a;overflow:hidden;padding:30px">

                    <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="520"
                        style="width:520px;max-width:520px;font-family:'Catamaran',Arial,Helvetica,sans-serif!important;font-size:16px;line-height:26px;font-weight:300;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px">
                        <tbody>
                            <tr>
                                <td align="center" valign="top"
                                    style="background-color:#fff;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0">

                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                        style="min-width:100%;border-collapse:collapse;background:#110e2a;">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top">
                                                                    <table align="left" border="0" cellpadding="0"
                                                                        cellspacing="0" width="100%"
                                                                        style="min-width:100%;border-collapse:collapse">
                                                                        <tbody>


                                                                            <tr>
                                                                                <td valign="top"
                                                                                    style="padding-top:9px;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:#fff;font-family:Helvetica;font-size:16px;line-height:150%;text-align:left">
                                                                                    <h1
                                                                                        style="display:block;margin:0;padding:0;color:#fff;font-family:Helvetica;font-size:35px;line-height:1!important;font-style:normal;font-weight:bold;letter-spacing:normal;text-align:center">
                                                                                        Welcome 🎉</h1>
                                                                                    <br>
                                                                                    <h6
                                                                                        style="display:block;margin:0;padding:0;color:#c4fd4a;font-family:Helvetica;font-size:24px;line-height:1!important;font-style:normal;font-weight:bold;margin-bottom:15px;letter-spacing:normal;text-align:center">
                                                                                        Your registration is successful
                                                                                    </h6>
                                                                                    <p
                                                                                        style="display:block;background-color:transparent;color:#7c77a7;font-family:arial;font-size:16px;margin-bottom: 10px;">
                                                                                        Here below details of your login
                                                                                        informations.
                                                                                    </p>

                                                                                    <p
                                                                                        style="display:block;background-color:transparent;color:#9c98bb;font-family:arial;font-size:16px;margin-bottom: 10px;">
                                                                                        <strong>User name: </strong>
                                                                                        {{$data}}
                                                                                    </p>
                                                                                    <p
                                                                                        style="display:block;background-color:transparent;color:#7c77a7;font-family:arial;font-size:16px;margin-bottom: 10px;">
                                                                                        Please, follow the link to
                                                                                        signin and set
                                                                                        your profile.
                                                                                    </p>
                                                                                    <br />
                                                                                    <hr />
                                                                                    <div style="height:15px;"></div>

                                                                                    <p
                                                                                        style="display:block;background-color:transparent;color:#7c77a7;font-family:arial;font-size:16px;margin-bottom: 10px;">
                                                                                        Should you have any kind of
                                                                                        questions or concerns, please,
                                                                                        feel free to get your help from
                                                                                        our <a href="#"
                                                                                            style="color:#c4fd4a;">customer
                                                                                            support .</a>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                        style="background:#110e2a;min-width:100%;border-collapse:collapse;margin-bottom:0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding-top:18px;padding-right:18px;padding-left:18px"
                                                                    valign="top" align="center">
                                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                                        style="border-collapse:separate!important;border-radius:5px;background-color:#c4fd4a">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="middle"
                                                                                    style="font-family:Arial;font-size:16px;border-radius:5px;background-color:#c4fd4a">
                                                                                    <a title="Verify Email address"
                                                                                        style="font-weight:bold; padding:15px;letter-spacing:normal;line-height:100%;text-align:center;text-decoration:none;color:#000;display:block; text-transform: uppercase;"
                                                                                        href="{{route('customer.login')}}" target="_blank">Login
                                                                                        now</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                        <tbody>
                            <tr>
                                <td height="10" style="font-size:50px;line-height:50px"></td>
                            </tr>
                            <tr>
                                <td height="26" style="border-bottom:4px dotted #e4e4e4;font-size:26px;line-height:26px">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                                        width="480" style="width:480px;max-width:480px">
                                        <tbody>
                                            <tr>
                                                <td align="center"
                                                    style="font-family:'Catamaran',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:480;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px">
                                                    <u></u>
                                                    <div>
                                                        © 2023 MyAffirmations. All Rights Reserved.
                                                        <div style="height:10px"></div>
                                                        You received this email because you signed up for MyAffirmations<br>
                                                        all-in-one platform that record and management your affirmations.
                                                        management.
                                                    </div>
                                                    <u></u>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="30" style="font-size:30px;line-height:30px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="50" style="font-size:50px;line-height:50px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endsection
