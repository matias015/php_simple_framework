<label for="">llamado <?php echo $yaAnotado->llamado ?>
    <?php if($yaAnotado->diasHabiles >= 1){ ?> 
        <input type="radio" name="mesa" value="<?php echo $yaAnotado->id ?>">
    <?php }else{ ?>
        Ya ha caducado el tiempo de desinscripcion    
    <?php }?>
    
    fecha:   <?php echo $yaAnotado->fecha ?>
</label>