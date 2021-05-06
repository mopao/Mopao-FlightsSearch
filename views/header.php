<header>
  <nav class="navbar navbar-expand-sm navbar-light " id="main-menu">
    <a class="navbar-brand" href="index.php?page=home">MOPAO</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo ($_GET['page']==='home' || !isset($_GET['page']))? 'active' : '' ?>" href="index.php?page=home">Home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($_GET['page']==='flights_list' || $_GET['page']==='flight_search')? 'active' : '' ?>" href="index.php?page=flight_search">Flights</a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href="#">Hotels</a>
        </li>-->
      </ul>
    </div>
  </nav>
</header>
