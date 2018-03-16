<script type="text/javascript">
 jQuery(document).ready(function($) {
     $('form').submit(function(e) {
         e.preventDefault();
         var first = $("[name='first']").val();
         var last  = $("[name='last']").val();
         var phone = $("[name='phone']").val();
         var email = $("[name='email']").val();
         var msg   = $("[name='message']").val();

         if (first == '' || last == '' || phone == '' || email == '') {
             alert("Please fill out all the form fields. Thanks!");
         }
         else {
             jQuery.ajax({
                 type: 'POST',
                 url: "<?php echo get_home_url();?>/wp-admin/admin-ajax.php",
                 data: {
                     action: 'contact_us_form',
                     first: first,
                     last: last,
                     phone: phone,
                     email: email,
                     msg: msg,
                 },
                 success: function(data) {
                     if (data=="0") {
                         jQuery(".alert-error").css("display", "block");
                         window.setTimeout(function(){
                             jQuery(".alert.alert-error").css("display", "none");
                         }, 20000);

                     }
                     else {
                         $('form')[0].reset();
                         jQuery(".alert.alert-success").css("display", "block");
                         window.setTimeout(function(){
                             jQuery(".alert.alert-success").css("display", "none");
                         }, 20000);
                     }
                 },
                 error: function(err) {
                     alert("We're sorry, something went wrong. You can always reach us by writing to Scott@RoyalLegalSolutions.com");
                     console.log(err.responseText);
                 }
             });
         }
     });
 });
</script>


<div class="info">
    <div class="title-group">
        <h3 class="title">Don't risk a lawsuit. Contact our legal experts today!</h3>
        <p class="description">Royal Legal Solutions is here to deliver the asset protection solutions to defend your wealth from potential litigation. Tell us what you want to accomplish and we'll provide the optimal plan for your business needs.</p>
        <address>
            <div class="location">
                <h4>Royal Legal Solutions</h4>
                <a href="https://goo.gl/maps/HeEpUQSNuro" target="_blank">2400 East Cesar Chavez Street, Suite #208, Austin, Texas 78702</a>
            </div>
            <p>Phone: 512.757.3994</p>
            <p>Fax: 512.842.9373</p>
        </address>
    </div>

    <div class="form-area">
        <div class="alert alert-success" style="display: none;"><p><strong>Thank You</strong> for contacting us</p></div>
        <div class="alert alert-error" style="display: none;"><p><strong>Error</strong> Please fill all the fields.</p></div>

        <form class="toggle" name="form" id="contact-form">
            <div class="row">
                <h4>Name</h4>
                <div class="double column">
                    <input type="text" name="first" placeholder="First" required/>
                    <input type="text" name="last" placeholder="Last" required>
                </div>
            </div>
            <div class="row">
                <h4>Phone</h4>
                <input type="tel" name="phone" placeholder="Number" required/>
            </div>
            <div class="row">
                <h4>Email</h4>
                <input type="email" name="email" placeholder="Address" required/>
            </div>
            <div class="row">
                <h4>Message</h4>
                <textarea name="message" rows="5" placeholder="Write a message..."></textarea>
            </div>
            <div class="row">
                <input type="submit" class="button" value="Get in Touch"/>
            </div>
        </form>
    </div>
</div>
