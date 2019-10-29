<?php
include('header.php');
include('nav.php');
?>

<body class="filters-body">


    <div class="filters-container">
        <div class="genres-container">
            <p id="filter-header">Filtrar por género</p>
            <ul class="genres-list">
                <?php 

                foreach ($genres as $genre) {
                    ?>
                    <li class="item-genre">
                        <input value=<?php echo $genre->name; ?> id=<?php echo $genre->name; ?> name="genres[]" type='checkbox' />
                        <label for=<?php echo $genre->name; ?>> <?php echo $genre->name; ?> </label>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="dates-container">
            <p id="filter-header">Filtrar por día de función</p>
            <div class="day-filter">
                <select name="" id="filter-day">
                    <?php 
                        foreach($showtimesList as $showtime){  
                            ?>
                             <option value=""><?php $date = DateTime::createFromFormat("Y-m-d", $showtime->getDate());
 											    echo $date->format("l"); ?></option>
                    <?php }
                    ?>
                </select>
            </div>
        </div>
        <button class="btn-dark-md" id="filter-btn">Filtrar</button>
    </div>
</body>