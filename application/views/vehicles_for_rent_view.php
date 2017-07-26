<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">
    <div class="row">
        <?php
        foreach($vehicles as $vehicle) {
            $image_folder = base_url() . "assets/images/" . strtolower($vehicle['year']) . "_" . str_replace(" ", "_", strtolower($vehicle['make'])) . "_" . strtolower($vehicle['model']);
            ?>
            <figure class="individual-vehicle">
                <img src="<?php echo $image_folder; ?>/1.jpg" alt="<?php echo $vehicle['year'] . " " . $vehicle['make'] . " " . $vehicle['model']; ?>" />
                <figcaption>
                    <h3><?php echo $vehicle['year'] . " " . $vehicle['make'] . " " . $vehicle['model']; ?></h3>
                    <p><?php echo $vehicle['description']; ?></p>
                    <div class="price">
                        $<?php echo $vehicle['daily_cost'] ?>
                    </div>
                </figcaption><i class="ion-plus-round"></i>
                <a href="<?php echo base_url(); ?>rent_vehicle/process_search/<?php echo $vehicle['id']; ?>"></a>
            </figure>
            <?php
        }
        ?>
    </div>
</div>