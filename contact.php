<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $to = $_POST['email']; 
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    
    
    $header = 'From: ' . $_POST['email'];

 
    if (mail($to, $subject, $body, $header)) {
        echo 'Email sent successfully!';
    } else {
        echo 'Failed to send email.';
    }
}
?>
<?php include "includes/nav.php"; ?>

<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Email Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" cols="30" rows="10" required></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="submit">
                        </form>
                    </div>
                </div> 
            </div>
        </div> 
    </section>
    <hr>
    <?php include "includes/footer.php"; ?>
</div>
