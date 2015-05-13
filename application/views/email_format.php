<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width" />
        <meta name="format-detection" content="address=no;email=no;telephone=no" />
        <title>Welcome to SimpleApp</title>
    </head>
    <body>
        <table id="emailBody" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;height: auto;width: 100%;background-color: #ebebeb;">
            <tr>
                <td align="center" valign="top" class="emailBodyCell" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 32px;padding-bottom: 32px;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;height: 100%;width: 100%;background-color: #ebebeb;">
                    <table width="544" border="0" cellpadding="0" cellspacing="0" class="eBox" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;width: 544px;">
                        <tr>
                            <td class="eHeader bg-color" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-left: 12px;padding-right: 12px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;background-color: #235daa;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                                    <tr>
                                        <td class="eHeaderLogo" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;height: 48px;text-align: left;font-weight: bold;color: #ffffff;">
                                            <h1><?= ($header != NULL) ? $header : 'Wish-Fish' ?></h1>
                                        </td>
                                        <!-- end .eHeaderLogo-->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="eBody alignCenter pdTp32" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 32px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: left;width: 512px;color: #54565c;background-color: #ffffff;">
                                <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 14px;line-height: 22px;">
                                    <?= (isset($mail_content)) ? $mail_content : '' ?>
                                </p>

                                <table border="0" align="center" cellpadding="0" cellspacing="0" class="mainBtn" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                                    <tr>

                                    </tr>
                                </table>
<!--                                        <table border="0" align="center" cellpadding="0" cellspacing="0" class="subtleBtn" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                                    <tr>
                                        <td style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 16px;padding-bottom: 32px;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 14px;color: #a1a2a5;">
                                            <a href="#" style="padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #a1a2a5;">
                                                <span style="text-decoration: none;color: #a1a2a5;">
                                                    Cancel subscription request
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </table>-->
                            </td>
                            <!-- end .eBody--> 
                        </tr>
                        <tr>
                            <td class="bottomCorners" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 544px;height: 16px;background-color: #ffffff;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="eFooter" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 14px;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 12px;line-height: 21px;width: 544px;color: #b2b2b2;">
                                <strong>Copyright © 2015 White Coda Inc.</strong> All rights reserved.
                            </td>
                        </tr>
                    </table>
                    <!-- end .eBox -->
                </td>
                <!-- end .emailBodyCell --> 
            </tr>
        </table>
    </body>
</html>
