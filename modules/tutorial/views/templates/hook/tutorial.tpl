<!-- Block mymodule -->
<div id="tutorial_block_home" class="block">
  <h4>{l s='Welcome!' mod='tutorial'}</h4>
  <div class="block_content">
    <p>Hello,
           {if isset($tutorial_name) && $tutorial_name}
               {$tutorial_name}
           {else}
               World
           {/if}
           !
    </p>
    <ul>
      <li><a href="{$tutorial_link}" title="Click this link">Click me!</a></li>
    </ul>
  </div>
</div>
<!-- /Block mymodule -->