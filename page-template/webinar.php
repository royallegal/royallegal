<?php
/* Template Name: Webinar */
get_header();


// Webinar Jam
$url = 'https://app.webinarjam.com/api/v2/webinar/';
$id  = '40af36a8a3';
$key = 'api_key=3704f0ffebf8231e09487b3d8d94e51f0ed9afa9d8f823c881475b4395a8e21a';

$ch = curl_init();  

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 

$response = curl_exec($ch);

curl_close($ch);
?>


<main>
    <?php
    print('_____');
    var_dump($response);
    print('_____');
    ?>
    <!-- <a href="http://{Your Website}/REST_Client.php?action=get_app_list" alt="app list">Return to the app list</a> -->
</main>


<?php get_footer(); ?>
