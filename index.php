<?php include ("includes/header.php");?>

<div class="flexslider">
  <ul class="slides">
    <li>
      <img src="images/banner1.jpg" alt="banner1" />
    </li>
    <li>
      <img src="images/banner2.jpg" alt="banner2" />
    </li>
    <li>
      <img src="images/banner3.jpg" alt="banner3" />
    </li>
  </ul>
</div>


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

<section>
<p>
	Our mission is to supply the best vape products on the market. For juice and vapes for the beginner to the advanced, we have something for everyone.
</p>
<p>
	Founded in July 2013 by Eugene Lee to help the community come together to promote a healthier lifestyle. Our knowledgeable team of skilled vape enthusiasts bring you an ideal learning experience every time you walk you through the door. Whether it be the average day-to-day smoker or a social smoker, vaping can be used as a great tool to quit smoking. Check out our great selection and wide variety of today’s best vape products and accessories on the market.
</p>
</section>

<?php include ("includes/footer.php");?>
