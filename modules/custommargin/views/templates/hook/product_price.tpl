<div id="allah" >
    <label class="form-control-label" for="prc">Cena po doliczniu marży (marża: {$value*100}%)</label>
    <div  class="input-group money-type">
        <div class="input-group-prepend">
            <span class="input-group-text">{$currency}</span>
        </div>
        <input type="text" class="form-control" id="prc"/>
    </div>
</div>
<script>
    $('.mb-3').has('.col-xl-2').append($('#allah'));
</script>
