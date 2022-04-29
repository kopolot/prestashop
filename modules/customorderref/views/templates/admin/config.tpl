{if $msg=="Sukcess"}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            {$msg}
        </p>
    </div>
{/if}
<div>
    <h2 style="margin-top:1rem;">Tworzy przykładowe nr zamówienia według wzoru twojego wzoru </h2> 

    <p style="font-size:1rem; margin-top:1rem;">Wprowadz dowolne znaki lub znaki specjalne z klucza:</p>
    <p style="font-size:1rem;">/YY/ - aktualny rok</p>
    <p style="font-size:1rem;">/MM/ - aktualny miesąc</p>
    <p style="font-size:1rem;">/NEXTOM/ - aktualne zamowienie w tym miesiącu</p>
    <p style="font-size:1rem;">/NEXTO/ - aktualne zamowienie ogółem</p>
    <p style="font-size:1rem;"> np. ABC/YY//MM/123/NEXTOM//NEXTO/</p>

    <form method="POST" action="">
    <div style="display:flex;  flex-wrap:no-wrap; flex-direction:row;  width:100%; justify-content:space-between;">
        <div style="display:flex; flex-direction:column; padding:2rem; justify-content:flex-start; width:50%;">
                <div style="display:flex; flex-direction:column; margin-top:1rem;">
                    <h3>Pole jest wymagane</h3>

                    <div style="display:flex; flex-direction:column; width:70%;">
                        <input
                            name="config"
                            type="text"
                            class="form-control form-control-lg"
                            placeholder="Wpisz tu swój ciąg znaków"
                            id="input2"
                            required
                            style=""
                            value="{$ref}"
                            onkeyup="change()"
                        />
                    </div>
                </div>
        </div>
 
        <div style="margin:3rem 5rem 0 0; width:40%; ">

            <h3>Przykładowy nr zamówienia</h3>

            <div style="display:flex; flex-direction:column;  align-items:streach;">
                <div style="display:flex; flex-direction:column; margin-bottom:1rem;">
                    <input class="form-control form-control-lg"  id="exa" type="text" disabled style=" display:inline-block;">
                </div>
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Potwierdź</button>
            </div>
        </div>
       
    </div>
    <script>
        change()
        function change(){
            let date = new Date()
            let value=$('#input2').val();
            value = value.replace('/YY/',date.getFullYear())
            if(value.indexOf('/MM/')!=-1)
                value = value.replace('/MM/',"0"+date.getMonth())
            //let nexto = Math.round(Math.random() * 1000)
            //let nextom = Math.round(Math.random() * 100)
            value = value.replace('/NEXTOM/',Math.round(Math.random() * 100))
            value = value.replace('/NEXTO/',Math.round(Math.random() * 1000))
            $('#exa').val(value);
        }
    </script>  
    </form>
</div>
