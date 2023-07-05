<div style="font-size:13px;">
    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        An user has updated <?php echo strtolower($email_post['data']['gender']) == 'f' ? 'her' : 'his'; ?> profile <br />
        <br />
        <table width="100%" border="1" cellpadding="3" cellspacing="0">
            <tr>
                <td>Name</td>
                <td><?php echo $email_post['user']->name . ' ' . $email_post['user']->last_name; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $email_post['user']->email; ?></td>
            </tr>
            <tr>
                <td>IMI ID</td>
                <td><?php echo $email_post['user']->imi_id; ?></td>
            </tr>
        </table>
        <br />
        <br />Find Below changes by the user: <br />
        <br />
        <table width="100%" border="1" cellpadding="3" cellspacing="0">
            <tr>
                <th>Field</th>
                <th>Old Value</th>
                <th>New Value</th>
            </tr>
            <?php

            foreach ($email_post['differences'] as $difference) {
                ?>
                <tr>
                    <td><?php echo ucwords(str_replace('_', ' ', $difference)); ?></td>
                    <td>
                        <?php

                        if ($difference == 'home_country' || $difference == 'office_country') {
                            $country = get_country_by_id($email_post['data_old'][$difference]);

                            if ($country) {
                                $country_name = $country->countries_name;
                                $email_post['data_old'][$difference] = $country_name;
                            }
                        }

                        ?>
                        <?php echo $email_post['data_old'][$difference] === 0 ? "" : $email_post['data_old'][$difference]; ?>
                    </td>
                    <td>
                        <?php

                        if ($difference == 'home_country' || $difference == 'office_country') {
                            $country = get_country_by_id($email_post['data'][$difference]);

                            if ($country) {
                                $country_name = $country->countries_name;
                                $email_post['data'][$difference] = $country_name;
                            }
                        }

                        ?>
                        <?php echo $email_post['data'][$difference] === 0 ? "" : $email_post['data'][$difference]; ?>
                    </td>
                </tr>
            <?php
        }

        ?>
        </table>
    </p>

    <br />
</div>