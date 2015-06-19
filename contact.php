<?php include ("includes/header.php");?>

<section>
<h2>Contact Us</h2>

<article>
<?php include ("contact-multiple.php");?>
</article>

<div class="newsletter">
    <h2>Join Our Newsletter</h2>
    <div class="newsContent">
        <form action="includes/newsletter.php" method="post" id="subscribe_form" name="subscribe_form">
        <input type="hidden" name="action" value="subscribe" />
        <input type="text" class="Textbox" id="name" name="name" value="Name" />
        <input type="email" class="Textbox" id="email" name="email" value="Email Address"  />
        <input type="submit" value="submit" class="btn Button" />
        </form>
    </div>
</div>

<?php include ("includes/footer.php");?>
