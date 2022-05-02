{if $checkable != null}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            This is a success alert with <a href="#">an example link</a>. Click me to
            delete
        </p>
    </div>
{/if}
<div>
    <form method="post" action="">
        <div class="form-group">
            <label class="form-control-label" for="input1">Normal input</label>
            <input type="text" class="form-control" id="input1" name="nie" value="{$tak}"/>
        </div>

        <button type="submit" class="btn btn-success" aria-label="Comfirm">
            <i class="material-icons">check</i> Comfirm
        </button>
    </form>
</div>