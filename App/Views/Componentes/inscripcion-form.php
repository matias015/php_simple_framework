<label for="">llamado <?php echo $mesa->llamado ?>
    <?php if($mesa->diasHabiles >= 2){ ?> 
        <input type="radio" name="mesa" value="<?php echo $mesa->id_mesa ?>">
    <?php }else{ ?>
        Ya ha caducado el tiempo de inscripcion    
    <?php }?>

    fecha:   <?php echo $mesa->fecha ?>
</label>