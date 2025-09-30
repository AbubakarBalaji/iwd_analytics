<?php  
include("path.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Services - IWD Analytics</title>
  <link rel="stylesheet" href="Assets/css/services.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include(ROOT_PATH . "/App/includes/Header.php"); ?>

<section class="services-hero">
  <div class="hero-flex-container">
    <div class="hero-icons">
      <i class="fas fa-chart-line" title="Analytics"></i>
      <i class="fas fa-database" title="Data Management"></i>
      <i class="fas fa-chart-pie" title="Visualization"></i>
      <i class="fas fa-project-diagram" title="M&E Systems"></i>
    </div>

    <h1>Empowering<br>Smart<br>Decisions</h1>

    <div class="hero-icons-secondary">
      <i class="fas fa-coins" title="Budget & Finance"></i>
      <i class="fas fa-balance-scale" title="Policy & Governance"></i>
      <i class="fas fa-chart-bar" title="Economy & Markets"></i>
      <i class="fas fa-building" title="Infrastructure"></i>
    </div>
  </div>
</section>

<section class="services-list">
  <div class="container">

    <div class="service-box">
      <h2>📊 Data Analysis & Visualization</h2>
      <p>We clean, process, and visualize your data through interactive dashboards and reports using tools like Power BI and Tableau, helping uncover key trends and drive smarter decisions.</p>
    </div>

    <div class="service-box">
      <h2>💼 Business Development</h2>
      <p>We support your growth by writing compelling proposals, bidding for contracts, preparing tenders, quotations, and professionally designed company profiles that win business.</p>
    </div>

    <div class="service-box">
      <h2>📝 Surveys & Data Collection</h2>
      <p>We design, implement, and analyze surveys for research, monitoring, and evaluation projects.</p>
    </div>

    <div class="service-box">
      <h2>🧠 Analytical Research & Insightful Reporting</h2>
<p>We conduct evidence-driven research and in-depth policy analysis to inform strategic decisions and enhance program effectiveness.</p>
    </div>

    <div class="service-box">
      <h2>📡 Monitoring & Evaluation (M&E)</h2>
      <p>We build and support M&E systems to track project performance and impact over time.</p>
    </div>

    <div class="service-box">
      <h2>🧑‍🏫 Training & Capacity Building</h2>
      <p>Hands-on training for your team in analytics, tools, and best practices in data and evaluation.</p>
    </div>

    <div class="service-box advert-box centered-box">
      <h2><i class="fas fa-bullhorn"></i> Adverts</h2>
      <p>Strategic advertisement services for government programs, major infrastructure projects, real estate campaigns, and data-driven video adverts.</p>
    </div>

    <div class="cta-buttons">
      <a href="contact.php" class="btn-primary">Contact Us</a>
    </div>

  </div>
</section>

<?php include(ROOT_PATH . "/App/includes/Footer.php"); ?>
</body>
</html>
