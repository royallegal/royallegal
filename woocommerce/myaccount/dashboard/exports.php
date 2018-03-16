<script>
 $(document).ready(function(){
     var download = $('.modal [name="download"]');
     var data;

     $('.modal-trigger').click(function() {
         var checked  = $('td.checkbox [name="select-profile"]:checked');
         var arr = [];
         var i = 0;

         $(checked).each(function() {
             var row      = $(this).closest('tr');
             var username = row.find('[name="username"]').val();
             var tables   = row.find('[name="tables"]').val();
             var fullname = row.find('[name="fullname"]').val();

             if (username != undefined) {
                 arr[i] = {
                     username: username,
                     tables: tables,
                     fullname: fullname
                 };
                 i++;
             }
         });
         data = arr;

         var jsonConvertedData = JSON.stringify(data);
         $(".selected_all_users_data").val(jsonConvertedData);
         $("#export_user_form").submit();
     });
 });
</script>


<!-- TABLE -->
<div class="vcenter spread">
    <h3>Users</h3>
    <div class="button-group">
        <input name=""
               class="small gray trigger button"
               type="button"
               value="Send Reminder"/>

                <form method="post" name="export_user_form" id="export_user_form" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <input type="hidden" name="selected_all_users_data" class="selected_all_users_data" value="">
                    <input name="download" class="small gray button modal-trigger" type="button" value="Export"/>
                </form>


    </div>
</div>

<hr class="push-down"/>

<table id="exports">
    <thead>
        <tr>
            <th class="checkbox">
                <div class="vcenter">
                    <input name="select-profile" type="checkbox" value=""/>
                    <i class="fa fa-sort"></i>
                </div>
            </th>
            <th class="activity">
                <div class="vcenter">
                    Activity
                    <i class="fa fa-sort"></i>
                </div>
            </th>
            <!-- <th class="username">
                 <div class="search vcenter">
                 <i class="fa fa-search"></i>
                 <input name="username" type="text" value="" placeholder="ID"/>
                 </div>
                 </th> -->
            <th class="first-name">
                <div class="search vcenter">
                    <i class="fa fa-search"></i>
                    <input name="first_name" type="text" value="" placeholder="First"/>
                </div>
            </th>
            <th class="last-name">
                <div class="search vcenter">
                    <i class="fa fa-search"></i>
                    <input name="last_name" type="text" value="" placeholder="Last"/>
                </div>
            </th>
            <th class="status">
                <div class="hcenter vcenter">
                    Status
                    <i class="fa fa-sort"></i>
                </div>
            </th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php
        // Cycles through users
        foreach ($tables['users'] as $key=>$user) {
            $status     = array();
            $username   = $user->user_login;
            $first_name = 'NA';
            $last_name  = 'NA';

            // Cycles through each users's account information
            foreach ($tables as $key=>$table) {
                if ($key != 'users') {

                    // Records the # of completed tables
                    foreach ($table as $data) {
                        if (!empty($data) && $username == $data->user) {
                            $name = get_name($key);
                            array_push($status, $name);
                        }
                    }
                }
            }

            // Cycles through each profile and populates user information
            foreach ($tables['profiles'] as $key=>$profile) {
                if ($username == $profile->user && $profile->relationship == "Owner") {
                    $first_name = $profile->first_name;
                    $last_name  = $profile->last_name;
                }
            }
        ?>

        <tr id="<?php echo $username; ?>">
            <td class="checkbox">
                <input name="select-profile" type="checkbox" value=""/>
            </td>
            <td class="activity">01-06-17</td>
            <!-- <td class="username"><?php echo $username ?></td> -->
            <td class="first-name"><?php echo $first_name ?></td>
            <td class="last-name"><?php echo $last_name ?></td>
            <td class="status">
                <?php
                $count = array();
                foreach ($tables as $key=>$table) {
                    $name = get_name($key);
                    (in_array($name,$status)) ? array_push($count,$name) : false;
                } ?>
                <p><?php echo count($count); ?> / 8</p>

                <ul class="tooltip">
                    <!-- <li class="heading">Completed Tables</li> -->
                    <?php foreach ($tables as $key=>$table) {
                        if ($key != 'users') {
                            $name = get_name($key);
                            if (in_array($name,$status)) {
                                echo '<li class="complete">';
                                echo '<i class="fa fa-fw fa-check"></i>';
                            }
                            else {
                                echo '<li class="incomplete">';
                                echo '<i class="fa fa-fw fa-times"></i>';
                            }
                            echo '<p>'.$name.'</p>';
                            echo '</li>';
                        }
                    } ?>
                </ul>
            </td>

            <td class="settings menu-trigger">
                <button class="gray"><i class="fa fa-cog"></i></button>
                <ul class="hidden gray dropdown menu">
                    <!-- View Profile -->
                    <li>
                        <i class="fa fa-fw fa-eye"></i>
                        View Profile
                    </li>

                    <!-- Email -->
                    <li>
                        <i class="fa fa-fw fa-download"></i>
                        Send Reminder
                    </li>

                    <!-- Export -->
                    <?php
                    if (count($count) >= 1) {
                        $sheets = array();
                        foreach ($count as $sheet) {
                            $name = "royal_" . strtolower($sheet);
                            array_push($sheets, $name);
                        }
                    ?>
                    <li>
                        <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                            <input type="hidden"
                                   name="username"
                                   value="<?php echo $username; ?>">
                            <input type="hidden"
                                   name="tables"
                                   value="<?php echo implode(",",$sheets); ?>">
                            <input type="hidden"
                                   name="fullname"
                            value="<?php echo $last_name.'-'.$first_name; ?>">
                            <button class="text button" name="download">
                                <i class="fa fa-fw fa-download"></i>
                                Export Data
                            </button>
                        </form>
                    </li>
                    <?php } ?>
                </ul>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
