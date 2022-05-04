{if $msg=="Sukcess"}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            {$msg}
        </p>
    </div>
{elseif $msg!==""}
    <div class="alert alert-danger" role="alert">
        <p class="alert-text">{$msg}</p>
    </div>
{/if}
<div>
    <h2>Wprowadz wartość marży</h2>
    <form action="" method="post" onsubmit="submit(e)">
        <div
            class="form-group ps-number-input ps-number-input-enable-arrows"
            data-max="300"
            data-min="0"
            data-label-max="Maximum:"
            data-label-min="Minimum:"
            data-label-nan="Not a number."
            style="width:13%;"
            
        >
            <div class="ps-number-input-inputs" style="display:flex; flex-direction:row;">
                <input class="form-control" type="text" name="value"  value="{$value}" id="input1" style="display:inline-block;"/>
                <span style="display:inline-block; font-size:1.5rem; padding:0.5rem;margin-top:-0.5rem">%</span>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Zapsiz</button>
    </form>
</div>