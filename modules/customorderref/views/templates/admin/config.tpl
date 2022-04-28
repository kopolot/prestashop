{if $msg!=null}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            {$msg}
        </p>
    </div>
{/if}
<div>
    <form method="POST" action="">
    <h3>Domyślmie tworzy id od 1 rosnąco</h3>
        <div class="form-select" style="margin-top:0.5rem; width:10%; display:inline-block;">
            <span>twój wybór/</span>
            <select class="form-control custom-select" name="config1" required>
                <option disabled selected>Wybierz sposób towrzenia id zamówienia</option>
                {* 1 moge zrobic od konkretnego numeru np 10 1000000000 -214289214 *}
                <option value="1" {if $value==1}selected{/if}>liczby rosnące od 1</option>
                <option value="2" {if $value==2}selected{/if}>np. 0000-1111-2222-3333</option>
                <option value="3" {if $value==3}selected{/if}>na podstawie daty np. PL/2022/1/4/2022</option>
                <option value="4" {if $value==4}selected{/if}>dowolne 3 litery</option>
            </select>
        </div>
        <div class="form-select" style="margin-top:0.5rem; width:10%; display:inline-block;">
            <span>/twój wybór/</span>
            <select class="form-control custom-select" name="config1" required>
                <option disabled selected>Wybierz sposób towrzenia id zamówienia</option>
                {* 1 moge zrobic od konkretnego numeru np 10 1000000000 -214289214 *}
                <option value="1" {if $value==1}selected{/if}>liczby rosnące od 1</option>
                <option value="2" {if $value==2}selected{/if}>np. 0000-1111-2222-3333</option>
                <option value="3" {if $value==3}selected{/if}>na podstawie daty np. PL/2022/1/4/2022</option>
                <option value="4" {if $value==4}selected{/if}>dowolne 3 litery</option>
            </select>
        </div>
        <div class="form-select" style="margin-top:0.5rem; width:10%; display:inline-block;">
            <span>/twój wybór/</span>
            <select class="form-control custom-select" name="config1" required>
                <option disabled selected>Wybierz sposób towrzenia id zamówienia</option>
                {* 1 moge zrobic od konkretnego numeru np 10 1000000000 -214289214 *}
                <option value="1" {if $value==1}selected{/if}>liczby rosnące od 1</option>
                <option value="2" {if $value==2}selected{/if}>np. 0000-1111-2222-3333</option>
                <option value="3" {if $value==3}selected{/if}>na podstawie daty np. PL/2022/1/4/2022</option>
                <option value="4" {if $value==4}selected{/if}>dowolne 3 litery</option>
            </select>
        </div>
        <div class="form-select" style="margin-top:0.5rem; width:10%; display:inline-block;">
            <span>/twój wybór</span>
            <select class="form-control custom-select" name="config1" required>
                <option disabled selected>Wybierz sposób towrzenia id zamówienia</option>
                {* 1 moge zrobic od konkretnego numeru np 10 1000000000 -214289214 *}
                <option value="1" {if $value==1}selected{/if}>liczby rosnące od 1</option>
                <option value="2" {if $value==2}selected{/if}>np. 0000-1111-2222-3333</option>
                <option value="3" {if $value==3}selected{/if}>na podstawie daty np. PL/2022/1/4/2022</option>
                <option value="4" {if $value==4}selected{/if}>dowolne 3 litery</option>
            </select>
        </div>
        <div style="margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Potwierdź</button>
        </div>
    </form>
</div>