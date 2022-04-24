<?php
session_start();
/**
* Template Name: register-member
*
* @package danang
* @subpackage Theme
* @since Twenty Fourteen 1.0
*/

get_header();
$errors = $_SESSION["validate"];
$success = $_SESSION["success"];
$error_name = '';
$error_body = '';
if($errors['errors']) {
  if (isset($errors['errors']['name'])) {
     foreach($errors['errors']['name'] as $value) {
      $error_name .= $value;
     }
  }
  if (isset($errors['errors']['body'])) {
    foreach($errors['errors']['body'] as $value) {
     $error_body .= $value;
    }
  }
}
unset($_SESSION['validate']);
unset($_SESSION['success']);

?>
<main class="container">
<div class="form-horizontal">
        <?php if($success) { ?>
            <div class="alert alert-success" role="alert">
                Bạn đã tạo thành công.
            </div>
        <?php } ?>
        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" novalidate="novalidate" id="contact_form" accept-charset="UTF-8" class="contact-form" onsubmit="window.Shopify.recaptchaV3.addToken(this, &quot;contact&quot;); return false;"><input type="hidden" name="form_type" value="contact"><input type="hidden" name="utf8" value="✓">
        <input type="hidden" name="action" value="main_theme_add_contact">
        <fieldset>
          <legend>Để lại lời nhắn</legend>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Name</label>
            <div class="col-sm-10">
              <input type="text" id="contactFormName" name="name" class="form-control" placeholder="Name" value="">
              <?php if ($error_name) {?>
              <small id="user-login-message" style="" class="form-text text-danger mb-4"><?=  $error_name ?></small>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Email</label>
            <div class="col-sm-10">
              <input type="text" id="contactFormEmail" name="email" class="form-control" placeholder="Email" autocorrect="off" autocapitalize="off" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Phone</label>
            <div class="col-sm-10">
              <input type="text" id="contactFormPhone" name="phone" class="form-control" placeholder="Phone" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">Message</label>
            <div class="col-sm-10"><grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT"></grammarly-extension>
              <textarea class="form-control" rows="10" id="contactFormMessage" name="body" placeholder="Message" spellcheck="false"></textarea>
              <?php if ($error_body) {?>
              <small id="user-login-message" style="" class="form-text text-danger mb-4"><?= $error_body ?></small>
              <?php } ?>
            </div>
          </div>
          
          <!-- <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">&nbsp;</label>
            <div class="col-sm-10">
              <p style="float: none; text-align: right; clear: both; margin: 10px 0;">
                <input style="float:none; vertical-align: middle;" type="checkbox" id="contact_accept_agree">
                <label style="display:inline; float:none" for="agree">
                  I agree with the terms and conditions.
                </label>
              </p>
            </div>
          </div> -->
          
        </fieldset>
        <div class="buttons submit">
          <div class="pull-right">
            <input class="btn btn-primary" id="submitMessage" name="submitMessage" type="submit" value="Gửi">
          </div>
        </div>

        </form>
      </div>
</main>
<?php get_footer(); ?>
