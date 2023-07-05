<?php
$name       = (isset($name) && !empty($name)) ? $name : "";
$address    = (isset($address) && !empty($address)) ? $address . "<br>" : "";
$email      = (isset($email) && !empty($email)) ? $email : "";
$project    = (isset($project) && !empty($project)) ? $project : "";
$amount     = (isset($amount) && !empty($amount)) ? $amount : "";
$date       = (isset($date) && !empty($date)) ? $date : "";
$serial_num = (isset($serial_num) && !empty($serial_num)) ? $serial_num : "";
?>
<style>
    * {
        box-sizing: border-box;
        color: #000;
        font-family: Arial, sans-serif;
    }

    a {
        color: #036eae;
    }

    p {
        font-size: 14px;
    }

    h1 {
        margin-bottom: 0;
    }

    table{
        padding:0;
        font-size: 15px;
        box-sizing: border-box;
        border-collapse: collapse;
    }	
    td,
    th {
        border: 1px solid;
        border-collapse: collapse;
        padding: 5px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .logo_left img {
        width: 100%;
    }

    .logo_left {
        float: left;
        width: 20%;
        margin-top: 20px;
    }

    .right {
        text-align: center;
        display: inline-block;
        margin-top: 20px;
        width: 80%;
    }

    td,
    th{
        border: 1px solid #000;
    }
</style>
<table style="width: 650px;margin: auto;padding-bottom: 20px;border:0; ">
<tbody><tr style="border:0;">
        <td style="border:0; width:120px;">
            <img src="assets/frontend/images/logo-canada.png" alt="logo-canada" style=" width:100%;">
        </td>
        <td style="border:0; width:450px;" align="center">
            <h1 style="font-size: 25px;">Imamia Medics International - Canada Inc</h1>
            <p style="margin-top: 6px;">IMI is in special consultative status with UN, accredited by UN since 2000 <br> UN
                since 2000
                22 Shasta Drive, Thornhill, ON L4J 1Z5, Canada<br>
                Phone: 647-965-0082<br>
                Web:<a href="https://imicanada.org"> www.imicanada.org</a></p>
        </td>
    </tr>
</tbody></table>
<div class="mainbody" style="width: 650px;margin: auto;  ">
    <table style="width: 650px;margin: auto;">
        <tr style="border:0;">
            <td style="border:0;padding: 0;">
                <table style="width: 100%;border-spacing: 0px;">
                    <thead>
                        <tr>
                            <th rowspan="2" style="border-bottom: 0; border-right:0;border-top: 0; border-left: 0;" align="left" width="50">
                            </th>
                            <th align="left" width="50">Receipt Date:</th>
                            <th align="left" width="50"> Receipt #:</th>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $date; ?></td>
                            <td align="center"><?php echo $serial_num; ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 0;" align="left" width="150" ><?php echo $name; ?> - <?php echo $serial_num; ?><br>
                                <?php echo $address; ?>
                                <?php echo $email; ?>
                            </td>
                            <td colspan="2" style="border-bottom: 0; border-right:0;border-top: 0; border-left: 0;"></td>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border:0; padding: 0;">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th> Amount ($)</th>
                        </tr>
                        <tr>
                            <td align="left"  style="border-bottom: 0;vertical-align: top;"><?php echo $date; ?></td>
                            <td align="left"  style="border-bottom: 0; vertical-align: top;" height="60"><?php echo $project; ?></td>
                            <td align="center"  style="border-bottom: 0; vertical-align: top;"><?php echo $amount; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><strong> Total:</strong></td>
                            <td align="center"><strong> $<?php echo $amount; ?></strong></td>
                        </tr>
                    </tbody>

                </table>
            </td>
        </tr>
    </table>
    <p><br></p>
    <p style="font-size: 19px;"><strong>This letter is to verify that no goods or services were received in lieu of this Donation.</strong></p>
    <p style="font-size: 21px;">Official Receipt for Income Tax Purpose. <br> CRA Charity Reg. # 83414 0048 RR0001</p>    
    <h2 style="text-align: center;font-size: 25px;">Thank you for your generous support!</h2>  
</div>