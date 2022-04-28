{if $msg=="Sukcess"}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            {$msg}
        </p>
    </div>
{else}
<div class="alert alert-error" role="alert">
        <p class="alert-text">
            {$msg}
        </p>
    </div>
{/if}
<div>
    <h2>Pierwsze pole wyboru jest wymagane, wszystkie pola tekstowe są opcjonalne</h2> 
    <form method="POST" action="">
    <div style="display:flex; justify-content:space-between;">
        {for $i=0 to $parts}
            <div class="form-select" style="margin-top:0.5rem; width:33%; display:inline-block;">   
            {if $i==0}
                <input
                    name="precon"
                    type="text"
                    class="form-control form-control-lg"
                    placeholder="REF"
                    id="input2"
                    style="width:17%; display:inline-block;"
                />
            {/if}
            <select class="form-control custom-select" name="config{$i}" required="required" style="display:inline-block; width:60%;">
            {foreach $names as $name}
                <option 
                    {if $value[$i]==$name['value']}selected{/if}
                    value="{$name['value']}"
                    {if $i == 0}required="required"{/if}
                >
                    {if $i == 0 && $name['value']== 0}Wybierz jedną z opcji{else}
                    {$name['name']}{/if}
                </option>
            {/foreach}
            </select>
            <input
                name="afcon{$i}"
                type="text"
                class="form-control form-control-lg"
                placeholder="Abcdz$"
                id="input2"
                style="width:21%; {if $i!=0}width:39%;{/if} display:inline-block;"
            />
            </div>
        {/for}
        </div>
        <div style="margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Potwierdź</button>
        </div>
    </form>
</div>