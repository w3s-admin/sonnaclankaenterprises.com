<div class="wrapper">
    <a href="<?= $server ?>index.php"><img id="logo" src="img/logo.png" alt="Nova" /></a>
    <!-- search -->
    <div class="top-search">
        <form  method="get" id="searchform" action="<?=$server ?>kaduwela_enterprises_search_vehicles.php">
            <div>
                <input type="text" value="Search..." name="key" id="s" onfocus="defaultInput(this)" onblur="clearInput(this)" />
                <input type="submit" id="searchsubmit" value=" " />
            </div>
        </form>
    </div>
    <!-- ENDS search -->
</div>