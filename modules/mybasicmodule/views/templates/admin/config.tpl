{if $message!=null}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
           {$message}
        </p>
    </div>
{else}

{/if}

<form action="" method="POST">
    <div class="form-group">
        <label class="form-control-label" for="input1">My module text</label>
        <input type="text" required class="form-control" value="{$ocena_akademika}" id="input1" name="ocena_akademika" />
        
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>