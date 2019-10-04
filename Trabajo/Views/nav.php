<nav class="nav-container">
    <a href="" class="nav-title">
      <h2>CinemApp</h2>
    </a>
    <form action="../process/searchMovie.php" method="GET">
      <div class="search-wrapper active">
        <div class="input-holder">
          <input name="title" type="text" class="search-input" placeholder="Type to search" />
          <button class="search-icon" onclick="searchToggle(this, event);"><span></span></button>
        </div>
        <!-- <span class="close" onclick="searchToggle(this, event);"></span> -->
      </div>
      <button type="button" class="btn btn-light mr-4">
       <label for="">Filtros Avanzados</label>
      </button>
    </form>
  </nav>