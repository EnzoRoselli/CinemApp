<?php
include('header.php');
include('nav.php');
?>

<body class="filters-body">

<form action="<?php echo  FRONT_ROOT . "/Filters/FilterMovies" ?>">
    <div class="filters-container">
        <div class="genres-container">
            <p id="filter-header">Filtrar por género</p>
            <ul class="genres-list">
                <?php foreach ($genres as $genre) {
                    ?>
                    <li class="item-genre">
                        <input value=<?php echo $genre->getId(); ?> id=<?php echo $genre->getName(); ?> name="genres[]" type='checkbox' />
                        <label for=<?php echo $genre->getName(); ?>> <?php echo $genre->getName(); ?> </label>
                    </li>
                <?php } ?>
            </ul>

        </div>
        <div class="dates-container">
            <p id="filter-header">Filtrar por día de función</p>
            <div class="day-filter">
                <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
        <button type="submit" class="btn-dark-md" id="filter-btn">Filtrar</button>
    </div>
</form>

</body>