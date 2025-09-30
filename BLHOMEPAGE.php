<?php 
include("path.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BL Services</title>
  <link rel="stylesheet" href="Assets\css\blhomepage.css"/>
</head>
<body>
  <header>
    <div class="logo">BL</div>
    <nav>
      <ul>
        <li><a href="#">ABOUT US</a></li>
        <li><a href="#">SERVICES</a></li>
        <li><a href="#">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <section class="intro">
    <h2>WHO WE ARE</h2>
    <p>
      Our Vision is drive a business forward with a seamless digital
      transformations through training, design, development and Media story Telling
    </p>
  </section>

  <section class="services">
    <h2>WHAT WE DO</h2>
    <div class="card-container">
      <!-- Card 1 -->
      <div class="card">
        <img src="https://via.placeholder.com/100x80?text=BL" alt="BL Logo">
        <ul>
          <li>Data Analysis</li>
          <li>Virtual Internship</li>
          <li>Training</li>
          <li>Report Writings</li>
          <li>Media Data Storytelling</li>
          <li>Adverts</li>
        </ul>
        <button>CONTACT US</button>
      </div>
      <!-- Card 2 -->
      <div class="card">
        <img src="https://via.placeholder.com/100x80?text=BL" alt="BL Logo">
        <ul>
          <li>Data Analysis</li>
          <li>Media Data Storytelling</li>
          <li>Adverts</li>
        </ul>
        <button>CONTACT US</button>
      </div>
      <!-- Card 3 -->
      <div class="card">
        <img src="https://via.placeholder.com/100x80?text=BL" alt="BL Logo">
        <ul>
          <li>Data Analysis</li>
          <li>Virtual Internship</li>
          <li>Training</li>
        </ul>
        <button>CONTACT US</button>
      </div>
    </div>
  </section>
</body>
</html>