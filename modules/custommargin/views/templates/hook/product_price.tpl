<div id="prcadd" >
    <label class="form-control-label" for="prc">Cena sprzedaży po doliczeniu marży (marża: {$value*100}%)</label>
    <div  class="input-group money-type">
            <input type="text" class="form-control"  id="prc" name="prc" readonly />
        <div class="input-group-append">
            <span class="input-group-text">{$currency}</span>
        </div>
    </div>
</div>
<script>
    $('#form_step2_wholesale_price').keyup((e)=>{
        let input = Math.round($('#form_step2_wholesale_price').val().replace(",",".")*{$value+1}*100)/100
        $('#prc').val(input)
        console.log($('#form_step2_price'))
        $('#form_step2_price').val(input)
        $('#form_step2_price').trigger('change')
        $('#form_step2_price').trigger('keyup')
    })
    $('#form_step2_wholesale_price').trigger('keyup')
    $('.mb-3').has('.col-xl-2').append($('#prcadd'));
   
</script>
